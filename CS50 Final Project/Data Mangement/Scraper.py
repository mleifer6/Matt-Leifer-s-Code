#!/usr/bin/env python
import urllib2
start = "http://ndb.nal.usda.gov/ndb/foods/show/"
end = "?reportfmt=csv"
for i in range(1,8790):
    URL = start + str(i) + end 
    entry = urllib2.urlopen(URL).read()
    filename = "food_item_" + str(i).zfill(4) +".csv"
    f = open(filename, 'w')
    f.write(entry)
    f.close()