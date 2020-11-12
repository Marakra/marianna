create database airblue;
create schema public;

create table points
(
    id serial not null
        constraint points_pk
            primary key,
    address varchar not null,
    lat double precision not null,
    lng double precision not null,
    parameters json not null,
    created_at timestamp not null,
    updated_at timestamp
);
