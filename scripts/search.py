# makes calls to database
from __future__ import print_function
from collections import defaultdict
from nltk.tokenize import TreebankWordTokenizer
import numpy as np
import sys
import math
import Levenshtein  # package python-Levenshtein
import json

# Extracts list of feelings from WeFeelFine API: http://wefeelfine.org/api.html
def get_feelings():
	#file_object = open("../data/feelings.txt", "r")
	file_object = open("data/feelings.txt", "r")
	lines = file_object.read().split('\n')
	words = []
	for line in lines:
		words.append(line.split('\t'))
	words = list(map(lambda a: a[0], words))
	return words


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

moods = {
	'angry': 'magnesium',
	'disgusted': 'fat',
	'frightened': 'carbohydrates',
	'surprised': 'manganese',
	'sad': 'vitamin d',
	'happy': 'vitamin b6'
}

def main():
	print(json.dumps(moods))

main()

# def format_input(food, mood, nutri):
# 	return food + " " + mood + " " + nutri
#
# print format_input(sys.argv[1], sys.argv[2], sys.argv[3])
