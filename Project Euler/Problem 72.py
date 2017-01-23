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

def farey_length(n):
    if n == 1:
        return 0
    else:
        return farey_length(n - 1) + phi(n) 

i = 2 
res = 0 
while i <= 1000000:
    res += phi(i)
    i += 1

print res
#print int(farey_length(1000000))