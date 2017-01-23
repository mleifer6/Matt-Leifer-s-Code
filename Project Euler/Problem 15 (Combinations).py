
# coding: utf-8

# In[30]:

#The question is asking what is 20 choose 10
def choose(x,y):
    if y>x: #if numbers are entered incorrectly
        x_temp=y
        y_temp=x
        x=x_temp
        y=y_temp
    numerator=1
    denominator=1
    for n in range(x-y+1,x+1,1):
        numerator=numerator*n
    for d in range(1,y+1,1):
        denominator=denominator*d
    print numerator/denominator


# In[34]:

choose(40,20) ##To get from 1 corner to another corner of a 20x20 grid with only down & right moves, we make 40 moves and we
#have to pick 20 downs.  


# In[29]:

numerator=1
for n in range(1,11,1):
    numerator=numerator*n
print numerator


# In[23]:




# In[ ]:



