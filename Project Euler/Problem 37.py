def is_prime(x):
    a=3
    if x<2:
        return False
    if x==2:
        return True
    if x%2==0:
        return False
    while a<=x**.5:
        if x%a==0:
            return False
            break
        a=a+2
    else:
        return True 

def largest_pow_ten(x):
    def aux(x,acc):
        if acc * 10 > x:
            return acc
        else:
            return aux(x,acc * 10)
    return aux(x,1)


def trunc_lr(x):
    if x < 10:
        return is_prime(x)
    else:
        return is_prime(x) and trunc_lr(x % (largest_pow_ten(x)))

def trunc_rl(x):
    if x < 10:
        return is_prime(x)
    else:
        return is_prime(x) and trunc_rl(x / 10)

def truncatable(x):
    return trunc_rl(x) and trunc_lr(x)

res = []
val = 11
while len(res) < 11:
    if truncatable(val):
        print val
        res.append(val)
    val += 2

print "Sum: %d" % sum(res)
