## Notes

### If database replication were used, it would be better to connect to the master database when reading data during the creation or update of a transfer request.

### This would prevent potential issues where a recently created record might not yet be available on the replica due to replication delay.

---
### It would have been possible to use UUIDs for the id columns of all tables to make record counts less guessable and to improve certain security aspects.

### However, while UUIDs offer these benefits, they also come with drawbacks such as increased storage size and potentially slower query performance.

### Alternative approaches, like using the Hashids package, could also be considered.

---
### It would have been possible to support and handle multiple currencies, allowing the system to process transfers in different currency types.

---

### Unfortunately, due to time constraints, I was not able to write tests for this task.

### However, you can refer to my other repositories for examples of my testing approach, such as the recently completed https://github.com/MohammadMehrabani/conditional-coupon repository.
