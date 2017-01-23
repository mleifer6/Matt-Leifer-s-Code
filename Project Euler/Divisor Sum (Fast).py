
# coding: utf-8

# In[2]:

def divisor_sum(a):
    import time
    start = time.time()
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
    print prime_factors
    number_of_divisors=1
    index=0
    count=0
    temp_dic={}
    while index<len(prime_factors):
        if prime_factors[index]!=prime_factors[index-1] or index==0:#This is because the -1st element of a list dne and we only
            #want to test each divisor once.  
            count=0
            check=0
            while check<len(prime_factors):
                if prime_factors[index]==prime_factors[check]:
                    count=count+1 #counts the number of times a divisor appears.  
                check=check+1 #goes through all the pfs to make sure we don't miss any pfs.  
            number_of_divisors=number_of_divisors*(count+1)
            temp_dic.update({prime_factors[index]:count}) #stores how many times a pf appears with the corresponding pf.  
        index=index+1
    #print number_of_divisors
    #print temp_dic
    product=1
    for key in temp_dic:
        #print key, test_dic[key], (key**(test_dic[key]+1)-1)/(key-1)
        product=product*(key**(temp_dic[key]+1)-1)/(key-1)
    elapsed = time.time() - start
    print "Result found in %s seconds" % elapsed
    return product-original #the formula for the sum of the divisors include the original number.


# In[3]:

divisor_sum(1234567890987654321)


# In[5]:

float(460.996603966)/0.153031826019 #This program was 3012 times faster than the other one. That one calculates every divisor 
#and adds them up, this one just finds the primes factors and uses a formula to add them up.  The only difference between these 
#two is that with the other one we know all of the divisors.  


# In[1]:




# In[ ]:



