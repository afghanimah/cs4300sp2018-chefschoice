import numpy as np
import sys 

def format_input(food, mood, nutri):
	return food + " " + mood + " " + nutri

print format_input(sys.argv[1], sys.argv[2], sys.argv[3])
