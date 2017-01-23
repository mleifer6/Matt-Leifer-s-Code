
# coding: utf-8

# In[1]:

def factorial(n):
    if n==0:
        return 1
    if n<=1:
        return n
    a=n*factorial(n-1)
    return a


# In[1]:




# In[2]:

solution=[int(i) for i in str(factorial(100))]
answer=0
count=0
while count<len(solution):
    answer=answer+solution[count]
    count=count+1
print answer


# In[15]:




# In[ ]:



