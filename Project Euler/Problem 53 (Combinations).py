
# coding: utf-8

# In[8]:

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
    return numerator/denominator


# In[17]:

count=0
for n in range(1,101):
    for r in range(1,101):
        if n>r:
            if choose(n,r)>1000000:
                count=count+1
print count


# In[14]:

choose(23,13)


##### 
