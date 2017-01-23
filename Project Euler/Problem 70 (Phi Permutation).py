
# coding: utf-8

# In[17]:

def phi(x):
    original=x
    divisor=2
    divisors=[]
    phi=x
    while divisor**2<=x:
        while x%divisor==0:        
            x=x/divisor
            divisors.append(divisor)
        divisor=divisor+1
    if x>1:
        divisors.append(x)
    #print divisors
    distinct_p=[]
    for a in divisors:
        if a not in distinct_p:
            distinct_p.append(a)
    ### Calculates phi(x)
    count=0
    while count<len(distinct_p):
        phi=phi*(1-((distinct_p[count])**(-1)))
        count=count+1
    return phi


# In[18]:

def is_same(x,y):
    word1=str(x)
    word2=str(y)
    if sorted(word1)==sorted(word2):
        return True
        #print 1


# In[24]:

import time 
start = time.time()

n=3
solution=[1,10**7]
while n<(10**7)+1:
    x=int(phi(n))
    if is_same(n,x):
        if float(n)/x<solution[1]:
            solution.remove(solution[0]) 
            solution.remove(solution[0])
            solution.append(n)
            solution.append(float(n)/x)
            print n
    n=n+2 ##If it's an even number then n/phi(n) is always at least 2.  

elapsed = time.time() - start
print "Result found in %s seconds" % elapsed
print solution


# In[23]:




# In[14]:




# In[ ]:



