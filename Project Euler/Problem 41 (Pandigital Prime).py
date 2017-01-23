
# coding: utf-8

# In[1]:

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


# In[3]:

maximum=0
import time
start = time.time()
for a in sieve(10**7):
    if (a>10**3 and a<10**4) or (a>10**6 and a<10**7):
        test=[int(c) for c in sorted(str(a))]
        digits=[x for x in range(1,len(str(a))+1)]
        if test==digits and a>maximum:
            maximum=a
elapsed = time.time() - start
print "Result found in %s seconds." % elapsed
print maximum


# In[ ]:



