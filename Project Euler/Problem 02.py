
# coding: utf-8

# In[1]:

#sum of even fibonacci numbers less than 4,000,000
x=1
y=1
count = 0
fib=[]
even_fib=[]
while x<4000000 and y<4000000:
    fib.append(x)
    fib.append(y)
    x=y+x
    y=y+x
    if x%2==0:
        even_fib.append(x)
    if y%2==0:
        even_fib.append(y)
print fib
print even_fib


# In[5]:

1346269+2178309


# In[6]:

sum(even_fib)


# In[ ]:



