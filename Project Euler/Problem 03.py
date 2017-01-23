
# coding: utf-8

# In[2]:

#Prime factor of a given number number and phi(x)
def pfs_and_phi(x): 
    divisor=2
    divisors=[]
    phi=x
    original=x
    while divisor**2<=x:
        while x%divisor==0:        
            x=x/divisor
            #print divisor,
            divisors.append(divisor)
        divisor=divisor+1
    if x>1:
        #print x
        divisors.append(x)
    print divisors
    distinct_p=[]
    for a in divisors:
        if a not in distinct_p:
            distinct_p.append(a)
    #print distinct_p
    count=0
    while count<len(distinct_p):
        phi=phi*(1-((distinct_p[count])**(-1)))
        count=count+1
    print phi


# In[ ]:




# In[4]:

pfs_and_phi(1499431860309233)


# In[ ]:

### Entire Program finds max x/phi(x) for a given upperbound
solution=[-10,-10] ###[x, x/phi(x)]
upperbound=1000000
x=1
original=x
while original<=upperbound:
    ### Determines prime factors
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
        count=count+1 ###When this loop is done 'phi' is the value of the totient function of x
    ### Determines largest x/phi(x) for a given upper bound 
    if original/phi>solution[1]:
        solution.remove(solution[0]) 
        solution.remove(solution[0])
        solution.append(original)
        solution.append(original/phi)
    original=original+1
    x=original #this has to be done because the value of x changes when the program goes through a loop and so it has to 
    #be reset like this
print solution


# In[ ]:




# In[ ]:



