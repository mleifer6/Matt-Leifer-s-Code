
# coding: utf-8

# In[15]:

def divisors(a):
    divisor=2
    prime_factors=[]
    while divisor**2<=a:
        while a%divisor==0:        
            a=a/divisor
            prime_factors.append(divisor)
        divisor=divisor+1
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
    #print number_of_divisors
    #print temp_dic
    return len(temp_dic)


# In[16]:

x=1
while divisors(x)!=4 or divisors(x+1)!=4 or divisors(x+2)!=4 or divisors(x+3)!=4:
    x=x+1
print x


# In[14]:

divisors(134043)
divisors(134044)
divisors(134045)
divisors(134046)


# In[ ]:



