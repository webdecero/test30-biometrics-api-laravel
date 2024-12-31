db.createUser(
    {
    user: "company-test", pwd: "2k9Ddh8tLdg1",
    roles: [ { role: "readWrite", db: "company-test" }, "readWrite" ]
    }
);


db.createUser(
    {
    user: "qa-test", pwd: "puI2iEauuFtO",
    roles: [ { role: "readWrite", db: "qa-test" }, "readWrite" ]
    }
);



db.createUser(
    {
    user: "biometrics", pwd: "cntPa2984k0ro0",
    roles: [ { role: "readWrite", db: "biometrics_web" }, "readWrite" ]
    }
);
