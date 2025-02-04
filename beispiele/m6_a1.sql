use emensawerbeseite;
Create table if not exists bewertungen(
    id INT8 Primary Key AUTO_INCREMENT,
    bemerkung VARCHAR(200) not null ,
    sternbewertung enum('sehr schlecht', 'schlecht', 'gut','sehr gut'),
    bewertungszeitpunkt datetime default now(),
    hervorheben boolean default false,
    gericht_id bigint not null ,
    foreign key (gericht_id) references gericht(id),
    check ( length(bemerkung)>4 ),
    benutzer_id bigint not null,
    foreign key (benutzer_id) references benutzer(id)
);