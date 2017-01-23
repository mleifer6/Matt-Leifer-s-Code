
# coding: utf-8

# In[4]:

def is_prime(x):
    a=3
    if x<2:
        return False
    if x==2:
        return True
    if x%2==0:
        return False
    while a<=x**.5:
        if x%a==0:
            return False
            break
        a=a+2
    else:
        return True 


# In[5]:

def primes(x):
    import time
    start = time.time()
    primes=[2]
    a=3
    while a<x:
        if is_prime(a):
            primes.append(a)
        a=a+1
    elapsed = time.time() - start
    print "Result found in %s seconds" % elapsed
    #print primes


# In[14]:

def sieve(x): #x=10
    import time
    start = time.time()
    primes=[]
    numbers=[[x,True] for x in range(2,x+1)] # [2,3,4,...10] 
    for i in range(2,x+1): # [2,3,4,...10]
        if numbers[i-2][1]==True: # The entry [2, True] is in the 0th spot, [3, True] in the 1st spot and so on.  
            for j in range(i**2, x+1, i): # Gets all the numbers from the square of the smallest i that is true to the maximum.
                numbers[j-2][1]=False # For example, the entry [4, True (to be made False)] is in the 2nd spot.  
            primes.append(i)
    elapsed = time.time() - start
    print "Result found in %s seconds" % elapsed
    print "There are %s primes less than %s. " %(len(primes),x)
    #print primes


# In[17]:

sieve(10000)


# In[16]:

def sieve2(x): #x=10
    import time
    start = time.time()
    primes=[]
    numbers=[True for x in range(2,x+1)] # [2,3,4,...10] 
    for i in range(2,x+1): # [2,3,4,...10]
        if numbers[i-2]==True: # The entry [2, True] is in the 0th spot, [3, True] in the 1st spot and so on.  
            for j in range(i**2, x+1, i): # Gets all the numbers from the square of the smallest i that is true to the maximum.
                numbers[j-2]=False # For example, the entry [4, True (to be made False)] is in the 2nd spot.  
            primes.append(i)
    elapsed = time.time() - start
    print "Result found in %s seconds" % elapsed
    print "There are %s primes less than %s. " %(len(primes),x)
    #print primes


# In[18]:

sieve2(10000)


# In[ ]:



