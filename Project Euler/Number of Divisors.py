
# coding: utf-8

# In[31]:

def divisors(a):
    #import time
    #start = time.time()
    original=a
    divisor=3
    prime_factors=[]
    while a%2==0:
        a=a/2
        prime_factors.append(2)
    while divisor**2<=a:
        while a%divisor==0:        
            a=a/divisor
            prime_factors.append(divisor)
        divisor=divisor+2
    if a>1:
        prime_factors.append(a)
    #print prime_factors
    number_of_divisors=1
    index=0
    count=0
    temp_dic={}
    while index<len(prime_factors):
        if prime_factors[index]!=prime_factors[index-1] or index==0:
            count=0
            check=0
            while check<len(prime_factors):
                if prime_factors[index]==prime_factors[check]:
                    count=count+1
                check=check+1
            number_of_divisors=number_of_divisors*(count+1)
            temp_dic.update({prime_factors[index]:count})
        index=index+1
    #elapsed = time.time() - start
    #print "Result found in %s seconds" % elapsed
    print "%s has %s divisors." % (original, number_of_divisors)
    print temp_dic


# In[32]:

divisors(2016)
divisors(168)


# In[33]:



