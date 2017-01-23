
# coding: utf-8

# In[2]:

def divisors(x): 
    potential_prime=2
    prime_factors=[]
    original=x
    while potential_prime**2<=x:
        while x%potential_prime==0:        
            x=x/potential_prime
            prime_factors.append(potential_prime)
        potential_prime=potential_prime+1
    if x>1:
        prime_factors.append(x)
    print prime_factors
    distinct_pfs=[]
    for a in prime_factors:
        if a not in distinct_pfs:
            distinct_pfs.append(a)
    print distinct_pfs
    divisors=[]
   # while original%1==0 and original !=1:
    #    original=original/prime_factors[0]
     #   divisors.append(original)
      #  prime_factors.remove(prime_factors[0])
    print divisors


# In[3]:

divisors(13*19*21)


# In[30]:




# In[30]:




# In[ ]:



