USE provaci_db;

INSERT INTO region (id, name) VALUES
    (1, "Abruzzo"),
    (2, "Basilicata"),
    (3, "Calabria"),
    (4, "Campania"),
    (5, "Emilia Romagna"),
    (6, "Friuli Venezia Giulia"),
    (7, "Lazio"),

    (8, "Liguria"),
    (9, "Lombardia"),
    (10, "Marche"),
    (11, "Molise"),
    (12, "Piemonte"),
    (13, "Puglia"),
    (14, "Sardegna"),
    (15, "Sicilia"),
    (16, "Toscana"),
    (17, "Trentino Alto Adige"),
    (18, "Umbria"),
    (19, "Valle d'Aosta"),
    (20, "Veneto");


INSERT INTO province (name, abbreviation, region) VALUES
    ("Agrigento", 'AG', 15),
    ("Alessandria", 'AL', 12),
    ("Ancona", 'AN', 10),
    ("Arezzo", 'AR', 16),
    ("Ascoli Piceno", 'AP', 10),
    ("Asti", 'AT', 12),
    ("Avellino", 'AV', 4),
    ("Bari", 'BA', 13),
    ("Barletta Andria Trani", 'BT', 13),
    ("Belluno", 'BL', 20),
    ("Benevento", 'BN', 4),
    ("Bergamo", 'BG', 9),
    ("Biella", 'BI', 12),
    ("Bologna", 'BO', 5),
    ("Bolzano", 'BZ', 17),
    ("Brescia", 'BS', 9),
    ("Brindisi", 'BR', 13),
    ("Cagliari", 'CA', 14),
    ("Caltanissetta", 'CL', 15),
    ("Campobasso", 'CB', 11),
    ("Carbonia Iglesias",'CI', 14),
    ("Caserta", 'CE', 4),
    ("Catania", 'CT', 15),
    ("Catanzaro", 'CZ', 3),
    ("Chieti", 'CH', 1),
    ("Como", 'CO', 9),
    ("Cosenza", 'CS', 3),
    ("Cremona", 'CR', 9),
    ("Crotone", 'KR', 3),
    ("Cuneo", 'CN', 12),
    ("Enna", 'EN', 15),
    ("Fermo", 'FM', 10),
    ("Firenze", 'FI', 16),
    ("Ferrara", 'FE', 5),
    ("Foggia", 'FG', 13),
    ("Forlì Cesena", 'FC', 5),
    ("Frosinone", 'FR', 7),
    ("Genova", 'GE', 8),
    ("Gorizia", 'GO', 6),
    ("Grosseto", 'GR', 16),
    ("Imperia", 'IM', 8),
    ("Isernia", 'IS', 11),
    ("L'Aquila", 'AQ', 1),
    ("La Spezia", 'SP', 8),
    ("Latina", 'LT', 7),
    ("Lecce", 'LE', 13),
    ("Lecco", 'LC', 9),
    ("Livorno", 'LI', 16),
    ("Lodi", 'LO', 9),
    ("Lucca", 'LU', 16),
    ("Macerata", 'MC', 10),
    ("Mantova", 'MN', 9),
    ("Massa e Carrara", 'MS', 16),
    ("Matera", 'MT', 2),
    ("Medio Campidano", 'VS', 14),
    ("Messina", 'ME', 15),
    ("Milano", 'MI', 9),
    ("Modena", 'MO', 5),
    ("Monza e Brianza", 'MB', 9),
    ("Napoli", 'NA', 4),
    ("Novara", 'NO', 12),
    ("Nuoro", 'NU', 14),
    ("Ogliastra", 'OG', 14),
    ("Olbia Tempio", 'OT', 14),
    ("Oristano", 'OR', 14),
    ("Padova", 'PD', 20),
    ("Palermo", 'PA', 15),
    ("Parma", 'PR', 5),
    ("Pavia", 'PV', 9),
    ("Perugia", 'PG', 18),
    ("Pesaro e Urbino", 'PU', 10),
    ("Pescara", 'PE', 1),
    ("Piacenza", 'PC', 5),
    ("Pisa", 'PI', 16),
    ("Pistoia", 'PT', 16),
    ("Pordenone", 'PN', 6),
    ("Potenza", 'PZ', 2),
    ("Prato", 'PO', 16),
    ("Ragusa", 'RG', 15),
    ("Ravenna", 'RA', 5),
    ("Reggio Calabria", 'RC', 3),
    ("Reggio Emilia", 'RE', 5),
    ("Rieti", 'RI', 7),
    ("Rimini", 'RN', 5),
    ("Roma", 'RM', 7),
    ("Rovigo", 'RO', 20),
    ("Salerno", 'SA', 4),
    ("Sassari", 'SS', 14),
    ("Savona", 'SV', 8),
    ("Siena", 'SI', 16),
    ("Siracusa", 'SR', 15),
    ("Sondrio", 'SO', 9),
    ("Taranto", 'TA', 13),
    ("Teramo", 'TE', 1),
    ("Terni", 'TR', 18),
    ("Torino", 'TO', 12),
    ("Trapani", 'TP', 15),
    ("Trento", 'TN', 17),
    ("Treviso", 'TV', 20),
    ("Trieste", 'TS', 6),
    ("Udine", 'UD', 6),
    ("Aosta", 'AO', 19),
    ("Varese", 'VA', 9),
    ("Venezia", 'VE', 20),
    ("Verbano Cusio Ossola", 'VB', 12),
    ("Vercelli", 'VC', 12),
    ("Verona", 'VR', 20),
    ("Vibo Valentia", 'VV', 3),
    ("Vicenza", 'VI', 20),
    ("Viterbo", 'VT', 7);

INSERT INTO gender(name) VALUES
    ('Uomo'),
    ('Donna'),
    ('Uomo Trans (FtM)'),
    ('Donna Trans (MtF)'),
    ('Intersessuale'),
    ('Nobinary'),
    ('Gender Fluid'),
    ('Altro');

INSERT INTO pronouns(name) VALUES
    ('He/Him'),
    ('She/Her'),
    ('They/Them'),
    ('Altro');

INSERT INTO orientation(name) VALUES
    ('Eterosessuale'),
    ('Gay'),
    ('Lesbica'),
    ('Bisessuale'),
    ('Polisessuale'),
    ('Omnisessuale'),
    ('Pansessuale'),
    ('Altro');

INSERT INTO whatLookingFor(name) VALUES
    ('Amicizia'),
    ('Relazione'),
    ('Relazione Stabile'),
    ('Matrimonio');

INSERT INTO interest(name) VALUES
    ('Anime'),
    ('Arte'),
    ('Astronomia'),
    ('Attivismo'),
    ('Attività fisica'),
    ('Cantare'),
    ('Club'),
    ('Collezionismo'),
    ('Cucinare'),
    ('Danza'),
    ('Dipingere'),
    ('Esplorare'),
    ('Fai da te'),
    ('Film'),
    ('Fitness'),
    ('Fotografia'),
    ('Giardinaggio'),
    ('Ginnastica'),
    ('Imprenditoria'),
    ('Investimenti'),
    ('Lavoro'),
    ('Leggere'),
    ('Lingue straniere'),
    ('Manga'),
    ('Mangiare'),
    ('Meditazione'),
    ('Modellismo'),
    ('Musica'),
    ('Pesca'),
    ('Poesia'),
    ('Programmazione'),
    ('Scacchi'),
    ('Scrivere'),
    ('Serie televisive'),
    ('Social media'),
    ('Sport'),
    ('Studio'),
    ('Suonare'),
    ('Teatro'),
    ('Tifoseria'),
    ('Viaggiare'),
    ('Videogame'),
    ('Vita notturna'),
    ('Volontariato');