import json
import sys

json_string = sys.argv[1]
json_parsed = json.loads(json_string)

#json.loads("json string")
#use as dictionary

print json_parsed