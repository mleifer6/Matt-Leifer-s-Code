
# coding: utf-8

# In[1]:

def ln(x):
    lnten=2.30258509299405
    step_size=.00001
    n=1
    total=0
    if x==10:
        return lnten
    if x<10: #equivalent to calculating int_{1}^{x}(1/x)dx
        while n<x:
            total=total+(step_size*(n**(-1)))
            n=n+step_size
    if x>10:
        count=0
        while x>10:
            x=x/10
            count=count+1
        return ln(x)+count*lnten
    return total


# In[25]:




# In[ ]:



