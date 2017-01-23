
# coding: utf-8

# In[56]:

def factorial(n):
    import time
    start = time.time()
    n=int(n)
    if n==0:
        return 1
    if n<=1:
        return n
        elapsed = time.time() - start
        print elapsed
    a=n*factorial(n-1)
    elapsed = time.time() - start
    #print "Result found in %s seconds" % elapsed 
    return a


# In[51]:

def smart_factorial(n):
    import time
    start = time.time()
    values={0:1}
    i=1
    n=int(n)
    while i<n+1:
        values.update({i:i*values[i-1]})
        i=i+1
    elapsed = time.time() - start
    print "Result found in %s seconds" % elapsed
    return values[n]


# In[52]:

#print smart_factorial(200000)
x=raw_input("Enter a number: ")
print smart_factorial(x)

# In[58]:

#factorial(20)


# In[ ]:



