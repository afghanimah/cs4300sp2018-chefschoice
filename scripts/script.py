import scrape
import numpy as np
from urllib.request import urlopen
#Thesaurus service provided by words.bighugelabs.com
def get_syn(f):
    # return #don't run
    feelings = f
    file_obj = open("output.txt", "w")
    for i in range(0,len(feelings)):
        print(i)
        try:
            newstr = str(feelings[i])
            page = urlopen('http://words.bighugelabs.com/api/2/0d152f7adb9f9d5812e0359248bf0e15/' + newstr + '/')
            page_content = page.read().decode("utf-8")
            print(newstr)
            for line in page_content.splitlines():
                split_line = line.split("|")
                if (split_line[1] == "syn") or (split_line[1] == "sim"):
                    newstr += " " + split_line[2]
            file_obj.write(newstr + "\n")
        except:
            print("FAIL " + newstr)
            pass
    file_obj.close()

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

# Extracts list of feelings from WeFeelFine API: http://wefeelfine.org/api.html
def get_synonyms():
	file_object = open("output.txt", "r+")
	lines = file_object.read().split('\n')
	words = []

	for line in lines:
		words.append(line.split('\t'))

	words = list(set(map(lambda a: a[0], words)))

	return words

def line_split_append(lst, sub, dl):
    for line in set(sub):
        words = line.split(dl)
        lst.append(list(set(words)))

def line_split_concat(lst, sub, dl):
    for line in sub:
        words = line.split(dl)
        lst += list(set(words))

# ["angry","disgusted","frightened","surprised","sad","happy"]
# OUTPUTS in form: [happy, sad, angry, surprised, disgusted, frightened]
def synonyms(feelings):
    """Returns a list of synonyms for each valid string in [feelings]"""
    get_syn(feelings)
    synonyms = get_synonyms()

    feelings_to_synonyms = []
    line_split_append(feelings_to_synonyms, synonyms, ' ')

    i = 0
    for feelings in feelings_to_synonyms:
        get_syn(feelings)
        synonyms_beta = get_synonyms()
        line_split_concat(feelings_to_synonyms[i], synonyms_beta, ' ')
        i += 1

    i = 0
    for lst in feelings_to_synonyms:
        feelings_to_synonyms[i] = list(set(lst))

    return feelings_to_synonyms
