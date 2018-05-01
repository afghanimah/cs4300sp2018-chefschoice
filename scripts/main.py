import json

mood_nutrition_mapping = {
	'angry': 'magnesium',
	'disgusted': 'fat',
	'frightened': 'carbs',
	'surprised': 'manganese',
	'sad': 'vitamin d',
	'happy': 'vitamin b6'
}

def main():
 	print(json.dumps(mood_nutrition_mapping))

main()
