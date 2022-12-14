CREATE TABLE _user (
    id INT NOT NULL,
    balance BIGINT NOT NULL DEFAULT (100),
    PRIMARY KEY (id)
);

CREATE TABLE _promise (
    id INT NOT NULL PRIMARY KEY,
    user_id INT NOT NULL ,
    task_name CHAR (255) NOT NULL,
    completed_date CHAR (10) NOT NULL,
    task TEXT,
    cost INT NOT NULL DEFAULT (10),
    is_completed BOOLEAN NOT NULL DEFAULT (FALSE),
    CONSTRAINT author FOREIGN KEY(user_id) REFERENCES _user(id)
);