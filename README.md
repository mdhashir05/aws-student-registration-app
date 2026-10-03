# AWS Student Registration Web Application

A PHP-based web application deployed on **Amazon EC2** and integrated with **Amazon RDS for MySQL** inside a custom **Amazon VPC**. This project demonstrates practical experience with AWS networking, compute, database integration, security groups, and cloud application deployment.

## Project Overview

The application enables users to register student details through a web form and view registered records stored in a MySQL database.

**Project status:** Successfully deployed and tested in AWS. The AWS resources were subsequently deleted to avoid ongoing charges; therefore, a live application endpoint is not currently available.

## Architecture

![AWS architecture diagram](screenshots/01-architecture-diagram.png)

### Application workflow

1. A user accesses the student registration form through a web browser.
2. The PHP application hosted on Amazon EC2 processes the submitted information.
3. The application connects to Amazon RDS for MySQL over TCP port `3306`.
4. Student records are inserted into the `students` table.
5. The application retrieves and displays registered student records.

The project uses a custom VPC with public and private subnets, route tables, an Internet Gateway, an EC2 web server, and an RDS MySQL database. The optional second EC2 instance and high-availability path in the architecture illustration represent design concepts, not confirmed deployed resources.

## Application Demonstration

### Student Registration

![Student registration form and success message](screenshots/02-application-registration-success.png)

The registration form collects a student's name, email address, course, and optional phone number. The screenshot documents a successful registration during testing.

### Registered Students

![Registered students displayed in a table](screenshots/03-registered-students-table.png)

The application retrieves student records from MySQL and displays information including student ID, name, email, course, and phone number.

## AWS Infrastructure

### Amazon EC2

![EC2 instance details](screenshots/04-ec2-instance-details.png)

The PHP web application was hosted on an EC2 instance named `student-web-server`. The captured console details show the instance type as `t3.micro`.

### Amazon VPC

![VPC details](screenshots/05-vpc-details.png)

A custom VPC named `student-app-vpc` was configured with the IPv4 CIDR block `10.0.0.0/16`.

### VPC Resource Map

![VPC resource map](screenshots/06-vpc-resource-map.png)

The resource map documents the VPC networking components, including subnets, route tables, and Internet Gateway connectivity.

### Subnet Configuration

![VPC subnet configuration](screenshots/07-vpc-subnets.png)

The AWS console evidence shows two public subnets and two private subnets.

| Subnet | IPv4 CIDR |
|---|---|
| `public-subnet-1` | `10.0.1.0/24` |
| `public-subnet-2` | `10.0.2.0/24` |
| `private-subnet-1` | `10.0.11.0/24` |
| `private-subnet-2` | `10.0.12.0/24` |

These values reflect the AWS console screenshots. The private subnet CIDRs in the architecture illustration differ from the console evidence.

### Route Tables

![VPC route tables](screenshots/08-vpc-route-tables.png)

The VPC configuration includes `student-public-RT`, `student-private-RT`, and the main route table.

### Database Security Group

![RDS security group](screenshots/09-rds-security-group.png)

The `student-RDS-SG` security group documents MySQL/Aurora access on TCP port `3306` from the application server's security group, limiting database access to the intended application tier.

### Amazon RDS for MySQL

![RDS database instance details](screenshots/10-rds-mysql-instance.png)

The managed database instance is named `student-registration-db`. The captured console details show the MySQL Community engine and port `3306`.

### SQL Verification

![MySQL query results](screenshots/11-mysql-query-results.png)

The SQL output documents successful retrieval of student records from the `students` table during testing.

## Technology Stack

- **Cloud platform:** Amazon Web Services (AWS)
- **Compute:** Amazon EC2
- **Networking:** Amazon VPC, public and private subnets, route tables, Internet Gateway
- **Database:** Amazon RDS for MySQL
- **Network security:** AWS security groups
- **Application:** PHP, HTML, CSS
- **Database language:** SQL
- **Tools:** Visual Studio Code, Git, GitHub

## Key Skills Demonstrated

- Deploying a PHP web application on Amazon EC2
- Creating and configuring a custom VPC
- Organizing public and private subnets
- Configuring route tables and Internet Gateway connectivity
- Provisioning and connecting to Amazon RDS for MySQL
- Controlling database traffic with security groups
- Implementing application-to-database connectivity
- Testing data insertion and retrieval
- Documenting cloud infrastructure and deployment evidence

## Security Considerations

- Database credentials should be stored in a protected configuration file or secrets-management service.
- AWS access keys, passwords, private keys, and other secrets must never be committed to a public repository.
- Database access should be restricted to the application server's security group.
- HTTPS/TLS was not demonstrated in the captured deployment and remains a potential improvement.
- Additional production improvements include stronger input validation, centralized secret management, monitoring, logging, and database backups.

## Cost Management

The AWS resources were deleted after testing to avoid ongoing charges. Recreating the environment may incur charges depending on the region, configuration, and resource usage.

## Future Improvements

- Configure HTTPS/TLS for encrypted browser traffic.
- Integrate AWS Secrets Manager or another protected credential-management solution.
- Improve input validation and error handling.
- Add monitoring, logging, and database backup procedures.
- Design and test a load-balanced, multi-AZ architecture if high availability is required.

## Repository Structure

```text
aws-student-registration-app/
├── README.md
├── index.php
├── style.css
└── screenshots/
    ├── 01-architecture-diagram.png
    ├── 02-application-registration-success.png
    ├── 03-registered-students-table.png
    ├── 04-ec2-instance-details.png
    ├── 05-vpc-details.png
    ├── 06-vpc-resource-map.png
    ├── 07-vpc-subnets.png
    ├── 08-vpc-route-tables.png
    ├── 09-rds-security-group.png
    ├── 10-rds-mysql-instance.png
    └── 11-mysql-query-results.png
```

**Author:** Mohammed Hashir 

**Project:** AWS Student Registration Web Application
