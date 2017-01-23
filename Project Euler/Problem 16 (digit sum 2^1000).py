
# coding: utf-8

# In[1]:

solution=[int(i) for i in str(2**1000)]
answer=0
count=0
while count<len(solution):
    answer=answer+solution[count]
    count=count+1
print answer


# In[ ]:



