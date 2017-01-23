
# coding: utf-8

# In[1]:

test="bcda"
tlist=[c for c in test]
tlist1=tlist
print tlist
tlist1.sort()
print tlist1
tlist1==tlist


# In[8]:

def is_same(x,y):
    word1=str(x)
    word2=str(y)
    if sorted(word1)==sorted(word2):
        return True
        print 1


# In[9]:

import time
 
start = time.time()

answer=[]
a=1
while len(answer)==0:
    if is_same(a,2*a) and is_same(a,2*a) and is_same(a,3*a) and is_same(a,4*a) and is_same(a,5*a) and is_same(a,6*a):
        answer.append(a)
    a=a+1
print answer

elapsed = time.time() - start
 
print "Result found in %s seconds" % elapsed


# In[4]:




# In[78]:




# In[ ]:



