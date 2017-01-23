
# coding: utf-8

# In[17]:

def factorial(n):
    if n==0:
        return 1
    if n<=1:
        return n
    a=n*factorial(n-1)
    return a

def dig_fac_sum(x):
    total=0
    digits=str(x)
    for i in digits:
        value=int(i)
        total=total+factorial(value)
    return total


# In[18]:

answers=[]
a=3
while a<2540161 and a>2:
    if a==dig_fac_sum(a):
        answers.append(a)
    a=a+1
print answers


# In[19]:

145+40585


# In[8]:




# In[ ]:



