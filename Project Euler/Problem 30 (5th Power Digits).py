
# coding: utf-8

# In[17]:

def digit_sum_5(x):
    total=0
    digits=str(x)
    for i in digits:
        value=int(i)**5
        total=total+value
    return total


# In[25]:

a=2
answers=[]
while a>1 and a<9**6+1:
    if digit_sum_5(a)==a:
        answers.append(a)
    a=a+1
total=0
for a in answers:
    total=total+a
print total


# In[4]:

digit_sum_5(1023)


# In[20]:

digit_sum_5(194979)


# In[23]:




# In[ ]:



