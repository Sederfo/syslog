import json
import sys

#this script is NOT used and NOT relevant

try:
    file_name = sys.argv[1]
    if ".json" not in file_name:
        print("File not a .json file!")
    else:
        with open(file_name, "r") as json_file:
            data=json.load(json_file)
except Exception as e:
    print("Exception!")



