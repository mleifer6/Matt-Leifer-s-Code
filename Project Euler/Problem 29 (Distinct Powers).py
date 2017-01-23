
# coding: utf-8

# In[7]:

answers=[]
for a in range(2,101):
    for b in range(2,101):
        if a**b not in answers:
            answers.append(a**b)


# In[9]:

len(answers)


# In[ ]:



