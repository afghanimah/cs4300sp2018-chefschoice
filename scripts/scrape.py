import json
from urllib.request import urlopen
#from search import get_feelings

oscar = "7ef5bf904b3608546445b27f4660b874"
me = "d509acf47e1890f5fda53f913d5f78db"
ab = "0d152f7adb9f9d5812e0359248bf0e15"

# Extracts list of feelings from WeFeelFine API: http://wefeelfine.org/api.html
def get_feelings():
    #copy paste from ab's code
    #outdated
	file_object = open("../data/feelings.txt", "r")
	lines = file_object.read().split('\n')
	words = []
	for line in lines:
		words.append(line.split('\t'))
	words = list(map(lambda a: a[0], words))
	return words

#Thesaurus service provided by words.bighugelabs.com
def get_syn():
    # return #don't run

    feelings = ["angry","disgusted","frightened","surprised","sad","happy"]

    for i in range(0,len(feelings)):
        print(i)
        try:
            newstr = str(feelings[i])
            page = urlopen('http://words.bighugelabs.com/api/2/0d152f7adb9f9d5812e0359248bf0e15/' + newstr + '/')
            page_content = page.read().decode("utf-8")
            print(newstr)
            for line in page_content.splitlines():
                split_line = line.split("|")
                if split_line[1] == "syn":
                    newstr += " " + split_line[2]
            file_obj = open("output.txt", "a")
            file_obj.write(newstr + "\n")
            file_obj.close()
        except:
            print("FAIL " + newstr)
            pass

def add_missing():
    #run once! (shouldn't matter though)
    #get current list of words that didn't fail
    #the first 2106 were scrapped from api
    file_obj = open("output.txt", "r")
    data = file_obj.read()
    file_obj.close()
    words = []
    for line in data.splitlines():
        words.append(line.split(" ")[0])
    all_feel = get_feelings()
    file_obj = open("output.txt", "a")
    for feel in all_feel:
        if not (feel in words):
            file_obj.write(feel + "\n")
    file_obj.close()

def to_word_list():
    #every word is it's own word
    file_obj = open("output.txt", "r")
    data = file_obj.read()
    file_obj.close()
    words = []
    for line in data.splitlines():
        for word in line.split(" "):
            words.append(word)
    return words

def to_doc_list():
    #every line is a document
    #the first word is the main word
    #every word after is a synonym (if any)
    file_obj = open("scripts/output.txt", "r")
    data = file_obj.read()
    file_obj.close()
    docs = []
    for line in data.splitlines():
        docs.append(line)
    return docs

def test():
    feelings = get_feelings()
    for i in range(0,len(feelings)):
        newstr = str(feelings[i])
        file = open("output.txt", "a")
        file.write(newstr + "\n")
        file.close()

def get_mimno():
    file_obj = open("data/recipes.tsv", "r")
    data = file_obj.read()
    file_obj.close()
    docs = []
    for line in data.splitlines():
        toks = line.split(" ")
        docs.append(" ".join(toks[1:]))
    return docs


# def get_data():
#     d, e = get_syn()
#     print("DATA:")
#     print (d)
#     print ("ERRORS:")
#     print (e)

# get_data()
# page = urlopen('http://words.bighugelabs.com/api/2/7ef5bf904b3608546445b27f4660b874/food/')
# page_content = page.read().decode("utf-8")print((page_content.splitlines()[0]).split("|"))
