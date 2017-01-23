
# coding: utf-8

# In[85]:

x= input() 
numbers=range(2,x+1) 
count=0
while count<len(numbers) and numbers[count]<=(x+1)**.5:
    for n in numbers:
        if n%numbers[count]==0 and n!=numbers[count]: #and numbers[count]<=n**.5: 
            ###This only needs to cycle through the primes less than the square root of the largest number to generate all the
            ###primes less than x. 
            numbers.remove(n)
    count=count+1
print numbers


# In[14]:

def is_prime(x):
    a=3
    if x%2==0 and x!=2:
        return False
    if x==2:
        return True
    while a<=x**.5:
        if x%a==0:
            return False
            break
        a=a+2
    else:
        return True 


# In[24]:

def primes(x):
    import time
    start = time.time()
    primes=[2]
    a=3
    while a<x:
        if is_prime(a):
            primes.append(a)
        a=a+1
    #print primes
    elapsed = time.time() - start
    total=0
    for p in primes:
        total=total+p
    print total
    print "Result found in %s seconds" % elapsed


# In[25]:

primes(200000)


# In[2]:

import time
start = time.time()
i=0
while i<10:
    print i
    i+=1
elapsed = time.time() - start
print "Result found in %s seconds" % elapsed


# In[ ]:



