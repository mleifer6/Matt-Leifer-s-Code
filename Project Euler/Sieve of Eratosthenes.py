import sys

def sieve(x): #x=10
    x = int(x)
    import time
    start = time.time()
    primes=[]
    numbers=[True for x in range(2,x+1)] # [2,3,4,...10] 
    for i in range(2,x+1): # [2,3,4,...10]
        if numbers[i-2]==True: # The entry [2, True] is in the 0th spot, [3, True] in the 1st spot and so on.  
            for j in range(i**2, x+1, i): # Gets all the numbers from the square of the smallest i that is true to the maximum.
                numbers[j-2]=False # For example, the entry [4, True (to be made False)] is in the 2nd spot.  
            primes.append(i)
    elapsed = time.time() - start
    #print primes
    print "Result found in %s seconds.\n" % elapsed
    print 'There are %(#p)s primes less than %(limit)s.\n' % {"#p":len(primes), "limit": x}
    print "The largest prime less than %d is %d.\n" % (x, primes[len(primes) - 1])

    #return primes[len(primes) - 1]
    #return elapsed


n = sys.argv[1]
sieve(n)
