create user admin with encrypted password 'admin';
create database bdrol with owner admin encoding 'utf8';
revoke all privileges on database bdrol from public;
grant all privileges on database bdrol to admin;
alter database bdrol set search_path to dungeonmaker;

\connect bdrol;
drop schema if exists dungeonmaker cascade;
create schema if not exists dungeonmaker authorization admin;

create user app with encrypted password 'app';
grant connect on database bdrol to app;
grant usage on schema dungeonmaker to app;
alter default privileges in schema dungeonmaker
    grant select, insert, update, delete on tables to app;
alter default privileges in schema dungeonmaker
    grant usage on sequences to app;
