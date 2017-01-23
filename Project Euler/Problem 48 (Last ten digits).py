
# coding: utf-8

# In[8]:

values=[]
for a in range(1,1001):
    values.append(a**a%10**10)  #found everything mod 10**10 to get the last ten digits of this massive number
total=0
for n in values:
    total=total+n
print total
print total%10**10


# In[7]:




# In[ ]:



