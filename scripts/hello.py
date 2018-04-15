import numpy as np

def hello_world():
    arr = np.zeros(5)
    hello = "hello"
    world = "world"
    return hello + " " + world + " " + str(arr.size)

print hello_world()
