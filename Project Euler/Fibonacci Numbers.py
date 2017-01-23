
# coding: utf-8

# In[5]:

def fib(n):
    x=1
    y=1
    count = 2
    while count<n:
        x=y+x
        count=count+1
        y=y+x
        count=count+1
    return y
    #print count


# In[13]:




# In[ ]:



