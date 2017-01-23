
# coding: utf-8

# In[27]:

def pfs(x): 
    divisor=3
    divisors=[]
    while x%2==0:
        x=x/2
        print 2,
        divisors.append(2)
    while divisor**2<=x:
        while x%divisor==0:        
            x=x/divisor
            print divisor,
            divisors.append(divisor)
        divisor=divisor+2
    if x>1:
        print x
        divisors.append(x)
    print divisors


# In[29]:

import time
start = time.time()
pfs(9120)
elapsed = time.time() - start
print "Result found in %s seconds" % elapsed


# In[25]:




# In[25]:




# In[18]:




# In[ ]:



