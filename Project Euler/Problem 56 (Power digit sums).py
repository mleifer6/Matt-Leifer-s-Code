
# coding: utf-8

# In[7]:

def dig_sum(a,b):
    value=str(a**b)
    total=0
    for i in value:
        total=total+int(i)
    return total


# In[12]:

max_value=0
for a in range(1,101):
    for b in range(1,101):
        if dig_sum(a,b)>max_value:
            max_value=dig_sum(a,b)
print max_value


# In[ ]:



