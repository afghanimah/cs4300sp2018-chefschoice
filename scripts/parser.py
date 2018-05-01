import json
import sys
#import search
from search import autosuggest#, get_feelings

#file is outdated

# number of feelings to suggest
NUM_FEELINGS = 10

json_string = sys.argv[1] #was 0
#json_parsed = json.loads(json_string)
json_parsed = json_string
feelings = []#get_feelings()

print(autosuggest(json_parsed, feelings, NUM_FEELINGS))
