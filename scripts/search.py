# makes calls to database
from __future__ import print_function
from collections import defaultdict
from nltk.tokenize import TreebankWordTokenizer
from functools import reduce

import numpy as np
import sys
import math
import Levenshtein  # package python-Levenshtein
import script
from synonyms import syns

# Below are findings for mapping moods to nutrient deficiencies:
# ANGER, DISGUST, FEAR, JOY, SADNESS, SURPRISE:
#https://www.telegraph.co.uk/science/2016/11/27/bad-mood-new-app-senses-emotion-suggests-food-lift-spirits/
#
#
# NOTE: 'fat' as mentioned below refers to omega-3 fatty acids. Because the current API in usage does not take omega-3 as one of the nutritional arguments, we establish recommendations based on the assumption that omega-3 fatty acids are correlated to unsaturated fats.

# Get two subsets for related terms and similar terms
mood_nutrition_mapping = {
	'angry': 'magnesium',
	'disgusted': 'fat',
	'frightened': 'carbs',
	'surprised': 'manganese',
	'sad': 'vitamin d',
	'happy': 'vitamin b6'
}

moods = ["frightened", "angry", "disgusted", "surprised", "sad", "happy"]
# represents a correspondence between moods at row i to synonyms in column j
syn_matrix = syns

# represents the number of synonyms per mood in mood_syn_matrix
mood_syn_count = list(map(lambda x: len(x), syn_matrix))

# representation of all synonyms ordered by order of retrieval in mood_syn_matrix
syn_vector = list(set(list(reduce(lambda x,y: x+y, syn_matrix))))[1:]

# an element m[i,j] is 1 if it is in the
mood_syn_matrix = np.zeros([6, len(syn_vector)])

# normalizes synonym occurences
i = 0
for row in syn_matrix:
	j = 0
	for word in row:
		if word in syn_vector:
			mood_syn_matrix[i][j] = 1
		j += 1
	mood_syn_matrix[i] = np.divide(mood_syn_matrix[i], len(row))
	i += 1


#calculates the edit distance between two words as implemented in assignment 03
def edit_distance(query, message,insertion_cost=1,deletion_cost=1,substitution_cost=2):
	""" Edit distance calculator

	@Parameters:
	-- [string]        query: query string
	-- [string]        message: message string
	-- [int or float]  insertion_cost: cost of insertion
	-- [int or float]  deletion_cost: cost of deletion
	-- [int or float]  substitution_cost: cost of substitution

	@Returns:
	-- an integer representing edit distance between two words, query and message. """

	m = len(query) + 1
	n = len(message) + 1
	chart = {}
	for i in range(m): chart[i,0] = i*deletion_cost
	for j in range(n): chart[0,j] = j*insertion_cost
	for i in range(1, m):
		for j in range(1, n):
			chart[i, j] = min(
				chart[i, j-1] + insertion_cost,
				chart[i-1, j] + deletion_cost,
				chart[i-1, j-1] + (0 if query[i-1] == message[j-1] else substitution_cost)
			)
	return chart[i, j]


def autosuggest(source, data, num_results):
	""" Auto-suggestion for input query
	@Parameters:
	-- [string]   source: query word
	-- [int]      num_results: number of top results to return
	-- [str list] data: dataset to perform search in

	@Returns:
	-- a list of the top [num_results] strings from [data] with closest character similarity from [source]
	"""
	results = data
	i = 0
	for letter in source:
		if len(results) == 1:
			return results
		results = list(filter(lambda s: len(s) > i, results))
		results = list(filter(lambda s: s[i] == letter, results))
		i += 1
	return results[:num_results]


def autocorrect(source, data, num_results):
	""" Auto-correction for input query
	@Parameters:
	-- [string]   source: query word
	-- [int]      num_results: number of top results to return
	-- [str list] data: dataset to perform search in

	@Returns:
	-- a list of the top [num_results] strings from [data] with lowest edit distance from [source]
	"""
	sorted_data_indices = np.asarray(data).argsort()
	results = {}
	for i in sorted_data_indices:
		results[data[i]] = edit_distance(source, data[i])

	ranked_results = sorted(results, key=results.get)
	return ranked_results[:num_results]

def calc_intersection(lst1, lst2):
	"""Returns the number of categories both lists have in common
	Params: {lst1: string list,
			 lst2: string list}
	Returns: integer
	"""
	count = 0
	for s in set(lst1):
		if s in lst2:
			count += 1
	return count

def calc_union(lst1, lst2):
	"""Returns the number of categories in both lists
	Params: {lst1: string list,
			 lst2: string list}
	Returns: integer
	"""
	arr = lst1 + lst2
	return len(set(arr))


def sims_jac(mood_input):
	"""
	Params: {n_mov: Integer,
			 input_data: List<Dictionary>}
	Returns: Numpy Array
	"""
	if mood_input in moods:
		return mood_input
	script.get_syn([mood_input])
	mood_input_syn = []
	script.line_split_concat(mood_input_syn, script.get_synonyms(), ' ')

	for mood in moods:
		if mood in mood_input_syn:
			return mood


	mat = np.zeros([6])
	intersect = 0
	union = 0
	data = syn_matrix

	i = 0
	for word in mood_input_syn:
		if word not in syn_vector:
			most_sim = autosuggest(word, syn_vector, 5)
			most_sim_arg = np.argsort(list(map(lambda x: edit_distance(x, word), most_sim)))
			if most_sim_arg != []:
				mood_input_syn[i] =  most_sim[most_sim_arg[0]]
		else:
			for i in range(len(syn_matrix)):
				if word in syn_matrix[i]:
					return moods[i]
		i += 1
	for i in range(0, len(moods)):
		intersect = calc_intersection(data[i], mood_input_syn)
		union = calc_union(data[i], mood_input_syn)
		mat[i] = intersect/union
	return moods[np.argmax(mat, axis=0)]

# def get_similar_mood(mood_input):
# 	""" Returns the most similar mood in [mood_nutrition_mapping] to [mood_input]
# 	@Parameters:
# 	-- [string] mood_input: mood inputted by user
#
# 	@Returns:
# 	-- a string representing the most similar mood
# 	"""
# 	if mood_input in moods:
# 		return mood_input
# 	script.get_syn([mood_input])
# 	mood_input_syn = []
# 	script.line_split_concat(mood_input_syn, script.get_synonyms(), ' ')
# 	mood_input_vector = np.zeros(len(syn_vector))
# 	for word in mood_input_syn:
# 		if word != '':
# 			most_sim = word
# 			if word not in syn_vector:
# 				most_sim = autosuggest(word, syn_vector, 5)
# 				most_sim_arg = np.argsort(list(map(lambda x: edit_distance(x, word), most_sim)))
# 				if most_sim != []:
# 					most_sim = most_sim[most_sim_arg[0]]
# 					word_index = syn_vector.index(most_sim)
# 					weight = 0.5
# 					if edit_distance(most_sim, mood_input) < 5:
# 						weight = 5
# 					mood_input_vector[word_index] = weight
# 			else:
# 				word_index = syn_vector.index(most_sim)
# 				weight = 5
# 				if word == mood_input:
# 					weight = 100
# 				mood_input_vector[word_index] = weight
# 	mood_scoring = np.dot(mood_syn_matrix, mood_input_vector)
# 	for i in range(len(syn_matrix)):
# 		mood_scoring[i] /= len(syn_matrix[i])
# 	return moods[np.argmax(mood_scoring, axis=0)]





# def format_input(food, mood, nutri):
# 	return food + " " + mood + " " + nutri
#
# print format_input(sys.argv[1], sys.argv[2], sys.argv[3])
