
# coding: utf-8

# In[78]:

#first number that's a multiple of the first 20 numbers
answer=[]
x=2
while len(answer)==0:
    if x%19==0 and x%17==0 and x%16==0 and x%15==0 and x%7==0 and x%13==0 and x%11==0 and x%9==0: 
        answer.append(x)
    x=x+2
#VERY INEFFICIENT (43 seconds). SHOULD RECONSIDER.


# In[79]:

answer


# In[85]:

solution_set={1:1}
for x in range(2,1000): ###Change range to get the lowest multiple of the first n numbers
    original=x
    divisor=2
    prime_factors=[]
    while divisor**2<=x:
        while x%divisor==0:        
            x=x/divisor
            prime_factors.append(divisor)
        divisor=divisor+1
    if x>1:
        prime_factors.append(x)
    #Calculates number of each divisor
    index=0
    count=0
    temp_dic={}
    while index<len(prime_factors):
        if prime_factors[index]!=prime_factors[index-1] or index==0:
            count=0
            check=0
            while check<len(prime_factors):
                if prime_factors[index]==prime_factors[check]:
                    count=count+1 #Count determines the number of times a factor appears.  
                check=check+1 #Cycles through the list of prime factors    
            temp_dic.update({prime_factors[index]:count}) #Assigns every factor to the number of times it appears. 
        index=index+1
    #print temp_dic
    count_2=0
    while count_2<len(solution_set):
        count_3=0
        while count_3<len(temp_dic):
            if solution_set.items()[count_2][0]==temp_dic.items()[count_3][0] and solution_set.items()[count_2][1]<temp_dic.items()[count_3][1]:
                del solution_set[solution_set.items()[count_2][0]]
                solution_set.update(temp_dic)  ###Checks to see if a prime factor occured more times than any previous number
            if temp_dic.items()[count_3][0] not in solution_set:
                solution_set.update(temp_dic) ###Adds any primes not already in the solution set
            count_3=count_3+1
        count_2=count_2+1
answer=1
count_4=0
while count_4<len(solution_set):
    answer=answer*(solution_set.items()[count_4][0]**solution_set.items()[count_4][1])
    count_4=count_4+1
print answer


# In[86]:




# In[ ]:



