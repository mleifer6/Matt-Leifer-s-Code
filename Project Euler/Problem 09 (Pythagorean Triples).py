
# coding: utf-8

# In[12]:

for a in range(1,999,1):
    for b in range(1,1000,1):
        for c in range(1,1001,1):
            if a+b+c==1000 and a**2+b**2==c**2:
                print a,b,c


# In[10]:

answer=[]
for a in range(1,10,1):
    for b in range(1,11,1):
        for c in range(1,12,1):
            if a+b+c==12 and a**2+b**2==c**2:
                answer.append(a)
                answer.append(b)
                answer.append(c)
                print a,b,c


# In[13]:




# In[ ]:



