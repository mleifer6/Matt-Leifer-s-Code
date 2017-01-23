
# coding: utf-8

# In[3]:

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

    
print float(choose(109,64))/choose(110,65)

# In[28]:

#Pascal's Triangle
'''
x=0
y=1
limit=23
while x<limit+1:
    y=0
    while y<=x:
        if y!=x:
            print choose(x,y),
        if y==x:
            print str(choose(x,y))+"\n"
        y+=1
    x+=1
'''

# In[6]:



# In[ ]:



