# makes calls to database
import numpy as np
import sys

moods = {
	'anger': 'magnesium',
	 'disgust': 'omega 3',
	 'fear': 'tryptophan'
	 'surprise': 'manganese'
	 'sadness': 'vitamin d'
	 'joy': 'vitamin b6'
}



def format_input(food, mood, nutri):
	return food + " " + mood + " " + nutri

print format_input(sys.argv[1], sys.argv[2], sys.argv[3])
