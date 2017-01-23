#!/usr/bin/env python
import urllib2
start = "http://www.cate.org/cateprofiles/"
end = ".jpg"
for i in range(1,1000):
    URL = start + str(i) + end 
    entry = urllib2.urlopen(URL).read()
    filename = "pic" + str(i).zfill(4) +".jpg"
    f = open(filename, 'w')
    f.write(entry)
    f.close()