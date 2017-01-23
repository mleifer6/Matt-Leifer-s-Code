
# coding: utf-8

# In[7]:

#Pallindromes that are the product of 2 three digit numbers
pallindromes=[]
for a in range(100,1000,1):
    for b in range(100,1000,1):
        if str(a*b)[::-1]==str(a*b):
            pallindromes.append(a*b)


# In[10]:

max(pallindromes)


# In[ ]:



