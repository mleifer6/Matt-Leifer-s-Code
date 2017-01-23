
# coding: utf-8

# In[94]:

def sieve(x): #x=10
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
    #print "Result found in %s seconds." % elapsed
    #print 'There are %(#p)s primes less than %(limit)s.' % {"#p":len(primes), "limit": x}
    return primes
    #return elapsed
    
def twice_square(n):
    if (n*.5)**.5%1==0:
        return True
    else:
        return False

def odd_composite(n):
    odds=[a for a in range(1,n,2)]
    primes=sieve(n)
    primes.remove(2)
    odd_composite=[]
    for a in odds:
        if a not in primes:
            odd_composite.append(a)
    return odd_composite


# In[99]:

upb=5790
oddcomps=odd_composite(upb)
primes=sieve(upb)
primes.remove(2)
i=1
j=0
success=[]
while oddcomps[i]>primes[j] and i<len(oddcomps)-1:
    while twice_square((oddcomps[i]-primes[j]))==False:
        #print j
        j=j+1
    if twice_square((oddcomps[i]-primes[j]))==True:
        success.append(oddcomps[i])    
    #print i*10
    i=i+1
    j=0
print success


# In[51]:




# In[21]:




# In[18]:




# In[ ]:



