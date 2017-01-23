
# coding: utf-8

# In[16]:

string=""
n=1
while len(string)<1000000:
    string=string+str(n)
    n=n+1
print len(string)
product=1
for a in range(0,7):
    product=product*int(string[(10**a)-1])
print product


# In[ ]:



