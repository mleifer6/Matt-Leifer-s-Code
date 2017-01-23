
# coding: utf-8

# In[1]:

def divisor_sum(x):
    import time
    start = time.time()
    divisors=[]
    a=1
    while a<x**.5+1:
        if x%a==0:
            divisors.append(a)
        a=a+1 #Gets all the divisors less than the sqrt of x
    for d in divisors:
        if x/d not in divisors and d!=1: #The !=1 ensures we don't inclue the original number
            divisors.append(x/d) #Gets all the divisors larger than sqrt of x
    total=0
    print divisors
    for d in divisors:
        total=total+d
    elapsed = time.time() - start
    #print "Result found in %s seconds" % elapsed
    return total


# In[2]:

print divisor_sum(13432929)


# In[ ]:



