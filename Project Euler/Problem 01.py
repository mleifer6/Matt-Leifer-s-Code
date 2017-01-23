
# coding: utf-8

# In[5]:

#find sum of the multiples of 3 and/or 5 less than 1000
multiples_of_3_and_5=[]
for i in range(1000):
    if i%3 ==0 or i%5==0:
        multiples_of_3_and_5.append(i)
print multiples_of_3_and_5


# In[6]:

sum(multiples_of_3_and_5)


# In[ ]:



