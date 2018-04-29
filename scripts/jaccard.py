import numpy as np
import sys

cuisines_dict = {
	"brazilian" : ["cilantro", "leaves", "lime", "brazilian", "large", "shrimp", "chopped", "garlic", "cider", "vinegar", "eggplant", "lemon", "zest", "chili", "tabasco", "pepper", "sauce", "ice", "cubes", "red", "curry", "paste", "dark", "rum", "lentils", "caraway", "seeds", "unsweetened", "coconut", "milk", "pineapple", "juice", "red", "bell", "pepper", "vegetable", "oil", "cilantro", "stems"],
	"british" : ["eggs", "milk", "butter", "salt", "british", "flour", "cream", "cheese", "southern", "us", "greek", "yogurt", "bananas", "vanilla", "sugar", "self", "rising", "flour", "vanilla", "extract", "bread", "lard", "chicken", "breast", "halves", "boiled", "egg", "nutmeg", "vegetable", "oil"],
	"cajun_creole" : ["cajun", "creole", "onions", "green", "bell", "pepper", "chicken", "broth", "celery", "salt", "garlic", "shrimp", "red", "bell", "pepper", "bacon", "dried", "basil", "bay", "leaves", "hot", "sauce", "green", "onions", "olive", "oil", "diced", "tomatoes", "medium", "shrimp", "water", "vegetable", "oil", "garlic", "cloves"],
	"chinese" : ["chinese", "soy", "sauce", "scallions", "sesame", "oil", "rice", "vinegar", "corn", "starch", "ginger", "sugar", "garlic", "fresh", "ginger", "salt", "water", "green", "onions", "honey", "white", "pepper", "oyster", "sauce", "hoisin", "sauce", "white", "wine", "light", "soy", "sauce", "garlic", "cloves"],
	"filipino" : ["garlic", "powder", "dried", "oregano", "salt", "filipino", "ground", "black", "pepper", "onion", "powder", "cooking", "oil", "lean", "ground", "beef", "paprika", "pepper", "water", "chicken", "thighs", "sweet", "onion", "onions", "garlic", "cayenne", "pepper", "peas", "pork", "shoulder", "dried", "parsley", "sage", "leaves"],
	"french" : ["french", "shallots", "leeks", "fresh", "thyme", "white", "wine", "vinegar", "chopped", "fresh", "thyme", "thyme", "thyme", "sprigs", "baking", "potatoes", "fennel", "bulb", "baguette", "anchovy", "fillets", "fennel", "seeds", "orange", "zest", "light", "corn", "syrup", "capers", "parsley", "sprigs", "water", "chopped", "fresh", "sage", "salt"],
	"greek" : ["minced", "garlic", "red", "wine", "vinegar", "cinnamon", "sticks", "clove", "greek", "black", "peppercorns", "mint", "leaves", "feta", "cheese", "diced", "onions", "bay", "leaves", "water", "english", "cucumber", "coriander", "seeds", "star", "anise", "cinnamon", "cardamom", "pods", "apples", "bay", "leaf", "honey", "blanched", "almonds"],
	"indian" : ["indian", "salt", "onions", "ground", "turmeric", "cumin", "seed", "garam", "masala", "water", "green", "chilies", "ginger", "tomatoes", "vegetable", "oil", "garlic", "chili", "powder", "fresh", "ginger", "cilantro", "leaves", "plain", "yogurt", "chile", "pepper", "potatoes", "basmati", "rice", "frozen", "peas"],
	"irish" : ["white", "sugar", "ground", "cinnamon", "irish", "ground", "nutmeg", "potatoes", "raisins", "egg", "whites", "ground", "cloves", "purpose", "flour", "grated", "lemon", "zest", "dark", "brown", "sugar", "salt", "fresh", "mushrooms", "vegetable", "oil", "cooking", "spray", "golden", "raisins", "ground", "allspice", "margarine", "vanilla", "extract", "seasoning", "granny", "smith", "apples"],
	"italian" : ["italian", "grated", "parmesan", "cheese", "olive", "oil", "zucchini", "plum", "tomatoes", "fresh", "basil", "leaves", "parmesan", "cheese", "shredded", "mozzarella", "cheese", "low", "salt", "chicken", "broth", "ricotta", "cheese", "pinenuts", "butter", "arborio", "rice", "pasta", "sauce", "prosciutto", "eggplant", "lasagna", "noodles", "asparagus", "marinara", "sauce", "skim", "mozzarella", "cheese"],
	"jamaican" : ["curry", "powder", "paprika", "cold", "water", "boneless", "skinless", "chicken", "breasts", "cracked", "black", "pepper", "jamaican", "bread", "crumbs", "heavy", "whipping", "cream", "meat", "chillies", "chicken", "pieces", "stock", "nutmeg", "jumbo", "shrimp", "pork", "butt", "scallion", "greens", "portabello", "mushroom", "malt", "vinegar", "chips", "onions"],
	"japanese" : ["japanese", "green", "onions", "mirin", "soy", "sauce", "shiitake", "sake", "sugar", "water", "vegetable", "oil", "daikon", "chili", "flakes", "corn", "oil", "dashi", "nori", "miso", "paste", "sushi", "rice", "salt", "white", "miso", "tofu", "konbu"],
	"korean" : ["korean", "carrots", "vegetable", "oil", "onions", "ground", "pork", "mushrooms", "soy", "sauce", "green", "onions", "garlic", "low", "sesame", "oil", "water", "pork", "beef", "noodles", "salt", "napa", "cabbage", "fresh", "ginger", "root", "water", "chestnuts", "red", "potato"],
	"mexican" : ["mexican", "sour", "cream", "salsa", "shredded", "cheddar", "cheese", "flour", "tortillas", "onions", "rice", "chili", "powder", "ground", "beef", "corn", "tortillas", "tomatoes", "shredded", "monterey", "jack", "cheese", "tortilla", "chips", "enchilada", "sauce", "cooked", "chicken", "taco", "seasoning", "green", "chile", "water", "refried", "beans", "cream", "cheese"],
	"moroccan" : ["moroccan", "ground", "ginger", "cayenne", "ground", "pepper", "chopped", "parsley", "paprika", "pitted", "kalamata", "olives", "fat", "couscous", "green", "olives", "dry", "mustard", "dried", "apricot", "sweet", "paprika", "onions", "chopped", "cilantro", "fresh", "cooked", "chicken", "breasts", "pepper", "jack", "salt", "fat", "skimmed", "chicken", "broth", "grapeseed", "oil"],
	"russian" : ["peeled", "fresh", "ginger", "mozzarella", "cheese", "russian", "sliced", "green", "onions", "cabbage", "italian", "seasoning", "garlic", "cloves", "flank", "steak", "dark", "sesame", "oil", "pork", "tenderloin", "low", "sodium", "soy", "sauce", "serrano", "chile", "red", "cabbage", "water", "pineapple", "beets", "lime", "rind", "lemon", "rind", "egg", "substitute", "dill"],
	"southern_us" : ["pepper", "salt", "lemon", "juice", "heavy", "cream", "southern", "us", "butter", "flour", "worcestershire", "sauce", "ketchup", "sliced", "mushrooms", "chicken", "broth", "bourbon", "whiskey", "grits", "hot", "sauce", "barbecue", "sauce", "marsala", "wine", "greens", "quickcooking", "grits", "sherry", "garlic", "cloves"],
	"spanish" : ["spanish", "dijon", "mustard", "ground", "white", "pepper", "orange", "capers", "fresh", "orange", "juice", "olive", "oil", "sherry", "vinegar", "olives", "crawfish", "sea", "scallops", "broth", "tomato", "juice", "agave", "nectar", "halibut", "fillets", "manchego", "cheese", "radicchio", "beaten", "eggs", "deveined", "shrimp", "fish", "stock"],
	"thai" : ["thai", "fish", "sauce", "vietnamese", "sugar", "coconut", "milk", "vegetable", "oil", "shallots", "garlic", "beansprouts", "peanuts", "chicken", "breasts", "lemongrass", "fresh", "lime", "juice", "lime", "juice", "water", "garlic", "cloves", "fresh", "ginger", "soy", "sauce", "shrimp", "shaoxing", "wine"],
	"vietnamese" : ["fresh", "mint", "orange", "juice", "sugar", "sweetened", "condensed", "milk", "vietnamese", "lettuce", "leaves", "mint", "water", "light", "coconut", "milk", "mint", "sprigs", "ice", "fresh", "shiitake", "mushrooms", "condensed", "milk", "coffee", "rice", "paper", "dipping", "sauces", "cocoa", "powder", "bird", "chile", "boneless", "pork", "loin", "navel", "oranges"]
}
 
cuisines_labels = {
	"brazilian" : "Brazilian",
	"british" : "British",
	"cajun_creole" : "Cajun Creole",
	"chinese" : "Chinese",
	"filipino" : "Filipino",
	"french" : "French",
	"greek" :  "Greek",
	"indian" : "Indian",
	"irish" : "Irish",
	"italian" : "Italian",
	"jamaican" : "Jamaican",
	"japanese" : "Japanese",
	"korean" : "Korean",
	"mexican" : "Mexican",
	"moroccan" : "Moroccan",
	"russian" : "Russian",
	"southern_us" : "Southern US",
	"spanish" : "Spanish",
	"thai" : "Thai",
	"vietnamese" : "Vietnamese"
}

cuisines_lst = [
	"brazilian", "british",	"cajun_creole",	"chinese", "filipino", "french", "greek", "indian",	"irish", "italian",
	"jamaican",	"japanese",	"korean", "mexican", "moroccan", "russian", "southern_us", "spanish", "thai", "vietnamese"
]

good_ingred = [
	"cilantro", "leaves", "lime", "brazilian", "large", "shrimp", "chopped", "garlic", "cider", "vinegar", "eggplant", "lemon",
	"zest", "chili", "tabasco", "pepper", "sauce", "ice", "cubes", "red", "curry", "paste", "dark", "rum", "lentils", "caraway",
	"seeds", "unsweetened", "coconut", "milk", "pineapple", "juice", "bell", "vegetable", "oil", "stems", "eggs", "butter", "salt",
	"british", "flour", "cream", "cheese", "southern", "us", "greek", "yogurt", "bananas", "vanilla", "sugar", "self", "rising",
	"extract", "bread", "lard", "chicken", "breast", "halves", "boiled", "egg", "nutmeg", "cajun", "creole", "onions", "green",
	"broth", "celery", "bacon", "dried", "basil", "bay", "hot", "olive", "diced", "tomatoes", "medium", "water", "cloves",
	"chinese", "soy", "scallions", "sesame", "rice", "corn", "starch", "ginger", "fresh", "honey", "white", "oyster", "hoisin",
	"wine", "light", "powder", "oregano", "filipino", "ground", "black", "onion", "cooking", "lean", "beef", "paprika", "thighs",
	"sweet", "cayenne", "peas", "pork", "shoulder", "parsley", "sage", "french", "shallots", "leeks", "thyme", "sprigs", "baking",
	"potatoes", "fennel", "bulb", "baguette", "anchovy", "fillets", "orange", "syrup", "capers", "minced", "cinnamon", "sticks",
	"clove", "peppercorns", "mint", "feta", "english", "cucumber", "coriander", "star", "anise", "cardamom", "pods", "apples",
	"leaf", "blanched", "almonds", "indian", "turmeric", "cumin", "seed", "garam", "masala", "chilies", "plain", "chile", "basmati",
	"frozen", "irish", "raisins", "whites", "purpose", "grated", "brown", "mushrooms", "spray", "golden", "allspice", "margarine",
	"seasoning", "granny", "smith", "italian", "parmesan", "zucchini", "plum", "shredded", "mozzarella", "low", "ricotta", "pinenuts",
	"arborio", "pasta", "prosciutto", "lasagna", "noodles", "asparagus", "marinara", "skim", "cold", "boneless", "skinless", "breasts",
	"cracked", "jamaican", "crumbs", "heavy", "whipping", "meat", "chillies", "pieces", "stock", "jumbo", "butt", "scallion", "greens",
	"portabello", "mushroom", "malt", "chips", "japanese", "mirin", "shiitake", "sake", "daikon", "flakes", "dashi", "nori", "miso",
	"sushi", "tofu", "konbu", "korean", "carrots", "napa", "cabbage", "root", "chestnuts", "potato", "mexican", "sour", "salsa",
	"cheddar", "tortillas", "monterey", "jack", "tortilla", "enchilada", "cooked", "taco", "refried", "beans", "moroccan", "pitted",
	"kalamata", "olives", "fat", "couscous", "dry", "mustard", "apricot", "skimmed", "grapeseed", "peeled", "russian", "sliced", "flank",
	"steak", "tenderloin", "sodium", "serrano", "beets", "rind", "substitute", "dill", "worcestershire", "ketchup", "bourbon", "whiskey",
	"grits", "barbecue", "marsala", "quickcooking", "sherry", "spanish", "dijon", "crawfish", "sea", "scallops", "tomato", "agave",
	"nectar", "halibut", "manchego", "radicchio", "beaten", "deveined", "fish", "thai", "vietnamese", "beansprouts", "peanuts",
	"lemongrass", "shaoxing", "sweetened", "condensed", "lettuce", "coffee", "paper", "dipping", "sauces", "cocoa", "bird", "loin",
	"navel", "oranges"
]

def get_intersection(lst1, lst2):
	#the score is a count, but items higher up the topic list are weighed more
	score = 0
	topic_len = len(lst2)
	score_per_unit = 1 / len(lst2)
	for i in range(0, topic_len):
		if lst2[i] in lst1:
			score += ((topic_len - i) * score_per_unit)
	return score

def get_union(lst1, lst2):
	return len(set(lst1 + lst2))

def create_j_sim_mat(search_results_lst):
    """Returns a matrix such that entry i,j is the Jaccard Similarity
	of search result i and topic(cuisine) j.
    
    Params: {search_results_lst : List of String Lists}
    Returns: Numpy Matrix
    """
    intersect = 0
    union = 0
    a = np.zeros([len(search_results_lst), len(cuisines_lst)])
    for i in range(0, len(search_results_lst)):
        for j in range(0, len(cuisines_lst)):
            intersect = get_intersection(search_results_lst[i], cuisines_dict[cuisines_lst[j]])
            union = get_union(search_results_lst[i], cuisines_dict[cuisines_lst[j]]) + 1
            a[i,j] = intersect / union
    return a

def get_top_k_results(mat, k=5):
	#because of how the PHP works above the python layer, we only need to do the first element at a time
    arr = mat[0]
    sort_idx = np.argsort(arr)[::-1][:k]
    results = ""
    for i in sort_idx:
        cuisine = cuisines_labels[cuisines_lst[i]]
        score = str(arr[i])
        results += cuisine + "|" + score + ","
    print(results[:-1])

def print_results(mat):
	for i in range(0, len(mat)):
		print(i)
		for j in range(0, len(cuisines_lst)):
			cuisine = cuisines_lst[j]
			print(cuisine + " : " + str(mat[i,j]))

def js_test():
	#results = [["avocado","black","pepper", "cayenne", "pepper", "chili","powder", "cilantro", "corn", "tortillas","cumin","flank","steak","garlic","powder","green","bell","pepper","jalapeno","limes","onion","powder","red","bell","pepper","salsa","salt","yellow","onion"]]
	#results = [["cilantro","guacamole","shredded","lettuce","canned","queso","dip","canned","fat","free","refried","beans","diced","tomato","yellow","tortillas"]]
	#results = [["avocados","fresh", "cilantro", "corn","tortillas","grapeseed","oil","iceberg","lettuce","queso","fresco","cheese","refried","beans","salsa","salt","tomatoes"]]
	results = [["curry","powder","extravirgin","olive","oil","garlic","clove","garlic","cloves","ground","cumin","fresh","lemon","juice","pitas","low","fat","plain","greek","yogurt","romaine","lettuce","salt","skinless","boneless","chicken","breast","tahini","tomato"]]
	mat = create_j_sim_mat(results)
	print_results(mat)

def main():
    ingreds = [sys.argv[1].split(" ")]
    mat = create_j_sim_mat(ingreds)
    top_k = get_top_k_results(mat)
    print(top_k)

main()