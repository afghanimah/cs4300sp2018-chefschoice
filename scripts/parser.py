import json
import sys
import search

# number of feelings to suggest
NUM_FEELINGS = 10

json_string = sys.argv[0]
json_parsed = json.loads(json_string)
feelings = get_feelings()

print(autosuggest(json_parsed, feelings, NUM_FEELINGS))
