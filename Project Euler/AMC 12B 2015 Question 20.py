
# coding: utf-8

# In[1]:

def f(i,j):
    if i==0 and 0<=j and j<=4:
        return (j+1)%5
    if i>=1 and j==0:
        return f(i-1,1)
    if i>=1 and 1<=j and j<=4:
        return f(i-1, f(i,j-1))


# In[2]:

i=0
values={}
j=0
while j<5:
    values.update({str(i)+str(j):f(i,j)})
    j=j+1
i=1
while i<2016:
    j=0
    while j<5:
        if j==0:
            v=values[str(i-1)+str(1)]
            values.update({str(i)+str(j):v})
        if j>=1 and j<=4:
            v=values[str(i-1)+str(values[str(i)+str(j-1)])]
            values.update({str(i)+str(j):v})
        j=j+1
    i=i+1
print values["20152"]


# In[3]:

def fast(x,y):
    i=0
    values={}
    j=0
    while j<5:
        values.update({str(i)+str(j):f(i,j)})
        j=j+1
    i=1
    while i<x+1:
        j=0
        while j<5:
            if j==0:
                v=values[str(i-1)+str(1)]
                values.update({str(i)+str(j):v})
            if j>=1 and j<=4:
                v=values[str(i-1)+str(values[str(i)+str(j-1)])]
                values.update({str(i)+str(j):v})
            j=j+1
        i=i+1
    print values[str(x)+str(y)]


# In[14]:

fast(2015,2)


# In[ ]:



