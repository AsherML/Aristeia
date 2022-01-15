-- TODO: create tables


-- Authors Table
CREATE TABLE authors(
    id          INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    author_name TEXT NOT NULL,
    field       TEXT NOT NULL,
    bio_source  TEXT,
    pic_source  TEXT,
    bio         TEXT NOT NULL,
    username    TEXT NOT NULL UNIQUE,
    password    TEXT NOT NULL
);

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (Null,"Neil Gaiman", "jpg", "https://www.neilgaiman.com/About_Neil/Biography", "https://images.gr-assets.com/authors/1234150163p5/1221698.jpg", "Neil Gaiman was born in Hampshire, UK, and now lives in the United States near Minneapolis. As a child he discovered his love of books, reading, and stories, devouring the works of C.S. Lewis, J.R.R. Tolkien, James Branch Cabell, Edgar Allan Poe, Michael Moorcock, Ursula K. LeGuin, Gene Wolfe, and G.K. Chesterton. A self-described " || '"' || "feral child who was raised in libraries" || '"' || ", Gaiman credits librarians with fostering a life-long love of reading: " || '"' || "I wouldn't be who I am without libraries. I was the sort of kid who devoured books, and my happiest times as a boy were when I persuaded my parents to drop me off in the local library on their way to work, and I spent the day there. I discovered that librarians actually want to help you: they taught me about interlibrary loans.", "Neil Gaiman", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (Null, "Claire North", "jpg", "https://www.clairenorth.com/", "https://images.gr-assets.com/authors/1440105009p5/7210024.jpg", "Claire North is the pen name for the Carnegie-nominated Catherine Webb, who also writes under the name Kate Griffin. Her latest book is the Pursuit of William Abbey. Catherine currently works as a live music lighting designer, teaches women’s self-defense, and is a fan of big cities, long walks, Thai food and graffiti-spotting. She lives in London.", "Claire North", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (Null, "Nick Harkaway", "jpg", "http://www.nickharkaway.com/", "http://www.nickharkaway.com/", "Have you ever sat down and tried to write something about yourself that is not trite, coy, absurd, overblown, or dull? Yeesh. This is my website. I am Nick Harkaway. I write books which you should certainly buy as soon as possible. I was born in Cornwall in the 70s and that is far too long ago. Mrs H and I have two small kids and she is by far the more interesting of us because she actually saves the world and I do not. I like: sourdough, lamb shawarma, Rioja Ardanza, Zidarich Vitovska, Kaisa Mäkäräinen and Cefalù. I do not like: packaged processed cheese, Brexit, the endless echoes of my own screw-ups, wearing a tie.", "Nick Harkaway", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES(Null, "Mona Awad", "png", "http://mona-awad-grou.squarespace.com/about", "https://images.squarespace-cdn.com/content/v1/55e1d02fe4b0c2065858614e/1541294802264-JXZ3G5A90WS5YTMP3VDG/ke17ZwdGBToddI8pDm48kPBFMf4CA1EHOHjtf5WHXY5Zw-zPPgdn4jUwVcJE1ZvWQUxwkmyExglNqGp0IvTJZUJFbgE-7XRK3dMEBRBhUpwp40KbuPPhqNQ-SXWRcdIcf2xHw3-hzMYH9lY-nkxnGqDIrQfDTh6pAobsGxnDxio/LACOMBE_18130_SHOT_1_MONA_AWAD_Q9A3711_A.png?format=1000w", "Mona Awad was born in Montreal and has lived in the US since 2009. Her debut novel, 13 WAYS OF LOOKING AT A FAT GIRL (Penguin, 2016), won the Amazon Best First Novel Award, the Colorado Book Award and was shortlisted for the Giller Prize and the Arab American Book Award. It was also long-listed for the Stephen Leacock Award for Humour and the International Dublin Award. BUNNY, her second novel (Viking, 2019), was a finalist for a GoodReads Choice Award for Best Horror, the New England Book Award, the Massachusetts Book Award, and it won The Ladies of Horror Fiction Best Novel Award. Her new novel, ALL’S WELL, will be released August 3rd 2021  with Simon & Schuster and  Penguin Canada.", "Mona Awad", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (NULL, "Edgar Cantero", "jpg", "http://punkahoy.blogspot.com/p/edgar-cantero.html", "https://1.bp.blogspot.com/-xfaDKyqrdY8/YA5urMCoTmI/AAAAAAAAC8A/y9CP-1GPUZQ--qt6-NNHM_y6vMODo3Q3QCLcBGAsYHQ/s240/ECantero2011.jpg", "My name is Edgar Cantero. I can write and draw. I was born in Barcelona in 1981. Trained in the battlefields of literary contests, the highbrow Catalan cultural tradition was soon outinfluenced in my mind by Hollywood blockbusters, videogames, and mass-market paperbacks.  My debut novel, Dormir amb Winona Ryder  (“Sleeping with Winona Ryder”, 2007) won the prestigious Joan Crexells award; the second one, the punk dystopian thriller Vallvi (2011), got me sizeably fewer honors and many confused stares. In English, I published the paranormal epistolar The Supernatural Enhancements in 2014.  It was followed by the horror/action/comedy Meddling Kids (2017), which became a New York Times bestseller.  There are dogs in both of them. I continue to write anything from short stories to screenplays.  My goal is to make beautiful popcorn fiction. My latest novel is This Body's Not Big Enough For Both of Us (2018).", "Edgar Cantero", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (Null, "Victoria 'V.E.' Schwab", 'jpg', "https://www.veschwab.com/about/", "https://www.veschwab.com/wp-content/uploads/2017/04/OfficialAuthorPhoto-768x512.jpg", "Victoria “V.E.” Schwab is the #1 NYT, USA, and Indie bestselling author of more than a dozen books, including Vicious, the Shades of Magic series, and This Savage Song. Her work has received critical acclaim, been featured by EW and The New York Times, been translated into more than a dozen languages, and been optioned for TV and Film. The Independent calls her the “natural successor to Diana Wynne Jones” and touts her “enviable, almost Gaimanesque ability to switch between styles, genres, and tones.”", "Victoria Schwab", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (Null, "Grady Hendrix", "jpg", "https://www.goodreads.com/author/show/4826394.Grady_Hendrix", "https://images.gr-assets.com/authors/1542284521p5/4826394.jpg", "Grady Hendrix is the author of the novels Horrorstör, about a haunted IKEA, and My Best Friend's Exorcism, which is like Beaches meets The Exorcist, only it's set in the Eighties. He's also the author of We Sold Our Souls, The Southern Book Club's Guide to Slaying Vampires, and the upcoming (July 13!) Final Girl Support Group! He's also the jerk behind the Stoker award-winning Paperbacks from Hell, a history of the 70's and 80's horror paperback boom, which contains more information about Nazi leprechauns, killer babies, and evil cats than you probably need. And he's the screenwriter behind Mohawk, which is probably the only horror movie about the War of 1812 and Satanic Panic.", "Grady Hendrix", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (Null, "Stuart Turton", "jpg", "https://www.goodreads.com/author/show/17160667.Stuart_Turton", "https://images.gr-assets.com/authors/1537181882p5/17160667.jpg", "Stuart lives in London with his amazing wife and daughter. He drinks lots of tea. What else? ​When he left university he went travelling for three months and stayed away for five years. Every time his parents asked when he’d be back he told them next week, and meant it. Stuart is not to be trusted. In the nicest possible way. He’s got a degree in English and Philosophy, which makes him excellent at arguing and terrible at choosing degrees. Having trained for no particular career, he has dabbled in most of them. He stocked shelves in a Darwin bookshop, taught English in Shanghai, worked for a technology magazine in London, wrote travel articles in Dubai, and now he’s a freelance journalist. None of this was planned, he just kept getting lost on his way to other places. He likes a chat. He likes books. He likes people who write books and people who read books. He doesn’t know how to write a biography, so should probably stop before he tells you about his dreams or something. It was lovely to meet you, though.","Stuart Turton", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (Null, "Catherynne M. Valente", "png", "https://www.goodreads.com/author/show/338705.Catherynne_M_Valente", "http://www.catherynnemvalente.com/wp-content/uploads/2015/02/author-pic.png", "Catherynne M. Valente was born on Cinco de Mayo, 1979 in Seattle, WA, but grew up in in the wheatgrass paradise of Northern California. She graduated from high school at age 15, going on to UC San Diego and Edinburgh University, receiving her B.A. in Classics with an emphasis in Ancient Greek Linguistics. She then drifted away from her M.A. program and into a long residence in the concrete and camphor wilds of Japan. She currently lives in Maine with her partner, two dogs, and three cats, having drifted back to America and the mythic frontier of the Midwest.", "Catherynne Valente", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (NULL, "Scott Hawkins", "jpg", "https://www.goodreads.com/author/show/8446300.Scott_Hawkins", "https://images.gr-assets.com/authors/1430050068p5/8446300.jpg", "I'm forty-nine and I live in the Atlanta suburbs with my wife and a whole bunch of dogs.", "Scott Hawkins", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");

INSERT INTO authors (id, author_name, field, bio_source, pic_source, bio, username, password) VALUES (NULL, "Austin Grossman", "jpg", "https://www.goodreads.com/author/show/71155.Austin_Grossman", "https://images.gr-assets.com/authors/1213307978p5/71155.jpg", "Austin Grossman graduated from Harvard University in 1991 with a plan to write the great American novel; instead he became a video game designer at Looking Glass Studios. He has since contributed as a writer and designer to a number of critically acclaimed video games, such as ULTIMA UNDERWORLD II, SYSTEM SHOCK, DEUS EX, and TOMB RAIDER: LEGEND, and has taught and lectured on narrative in video games. He is currently a freelance game design consultant, and he is also a doctoral candidate in English Literature at the University of California at Berkeley, where he specializes in Romantic and Victorian literature.", "Austin Grossman", "$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.");


--Books table
CREATE TABLE books(
    id              INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    title           TEXT NOT NULL,
    field           TEXT NOT NULL,
    pic_source      TEXT,
    summary_source  TEXT,
    summary         TEXT NOT NULL,
    author_id       INTEGER NOT NULL,

    FOREIGN KEY(author_id) REFERENCES authors(id)
);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "American Gods", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1462924585l/30165203.jpg", "https://www.goodreads.com/book/show/30165203-american-gods", "Days before his release from prison, Shadow's wife, Laura, dies in a mysterious car crash. Numbly, he makes his way back home. On the plane, he encounters the enigmatic Mr Wednesday, who claims to be a refugee from a distant war, a former god and the king of America."||CHAR(13)||CHAR(10)|| "Together they embark on a profoundly strange journey across the heart of the USA, whilst all around them a storm of preternatural and epic proportions threatens to break. \n

Scary, gripping and deeply unsettling, American Gods takes a long, hard look into the soul of America. You'll be surprised by what - and who - it finds there... (Source: Goodreads)", 1);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "The First Fifteen Lives of Harry August", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1493966668l/35066358._SY475_.jpg", "https://www.goodreads.com/book/show/35066358", "Some stories cannot be told in just one lifetime. Harry August is on his deathbed. Again. No matter what he does or the decisions he makes, when death comes, Harry always returns to where he began, a child with all the knowledge of a life he has already lived a dozen times before. Nothing ever changes. Until now. As Harry nears the end of his eleventh life, a little girl appears at his bedside. “I nearly missed you, Doctor August,” she says. “I need to send a message.” This is the story of what Harry does next, and what he did before, and how he tries to save a past he cannot change and a future he cannot allow.", 2);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "Angelmaker", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1326121401l/12266560.jpg", "https://www.goodreads.com/book/show/12266560", "From the acclaimed author of The Gone-Away World, blistering gangster noir meets howling absurdist comedy as the forces of good square off against the forces of evil, and only an unassuming clockwork repairman and an octogenarian former superspy can save the world from total destruction. \n
Joe Spork spends his days fixing antique clocks. The son of infamous London criminal Mathew “Tommy Gun” Spork, he has turned his back on his family’s mobster history and aims to live a quiet life. That orderly existence is suddenly upended when Joe activates a particularly unusual clockwork mechanism. His client, Edie Banister, is more than the kindly old lady she appears to be—she’s a retired international secret agent. And the device? It’s a 1950s doomsday machine. Having triggered it, Joe now faces the wrath of both the British government and a diabolical South Asian dictator who is also Edie’s old arch-nemesis. On the upside, Joe’s got a girl: a bold receptionist named Polly whose smarts, savvy and sex appeal may be just what he needs. With Joe’s once-quiet world suddenly overrun by mad monks, psychopathic serial killers, scientific geniuses and threats to the future of conscious life in the universe, he realizes that the only way to survive is to muster the courage to fight, help Edie complete a mission she abandoned years ago and pick up his father’s old gun...", 3);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "Bunny", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1544742360l/42815544.jpg", "https://www.goodreads.com/book/show/42815544", "Samantha Heather Mackey couldn't be more of an outsider in her small, highly selective MFA program at New England's Warren University. A scholarship student who prefers the company of her dark imagination to that of most people, she is utterly repelled by the rest of her fiction writing cohort--a clique of unbearably twee rich girls who call each other “Bunny,” and seem to move and speak as one. \n

But everything changes when Samantha receives an invitation to the Bunnies' fabled “Smut Salon,” and finds herself inexplicably drawn to their front door--ditching her only friend, Ava, in the process. As Samantha plunges deeper and deeper into the Bunnies' sinister yet saccharine world, beginning to take part in the ritualistic off-campus “Workshop” where they conjure their monstrous creations, the edges of reality begin to blur. Soon, her friendships with Ava and the Bunnies will be brought into deadly collision. \n

The spellbinding new novel from one of our most fearless chroniclers of the female experience, Bunny is a down-the-rabbit-hole tale of loneliness and belonging, friendship and desire, and the fantastic and terrible power of the imagination.", 4);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "Meddling Kids", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1568849620l/32905343._SY475_.jpg", "https://www.goodreads.com/book/show/32905343", "1990. The teen detectives once known as the Blyton Summer Detective Club (of Blyton Hills, a small mining town in the Zoinx River Valley in Oregon) are all grown up and haven't seen each other since their fateful, final case in 1977. Andy, the tomboy, is twenty-five and on the run, wanted in at least two states. Kerri, one-time kid genius and budding biologist, is bartending in New York, working on a serious drinking problem. At least she's got Tim, an excitable Weimaraner descended from the original canine member of the team. Nate, the horror nerd, has spent the last thirteen years in and out of mental health institutions, and currently resides in an asylum in Arhkam, Massachusetts. The only friend he still sees is Peter, the handsome jock turned movie star. The problem is, Peter's been dead for years. \n

The time has come to uncover the source of their nightmares and return to where it all began in 1977. This time, it better not be a man in a mask. The real monsters are waiting. (Source: Goodreads)", 5);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "Vicious", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1532011194l/40874032._SY475_.jpg", "https://www.goodreads.com/book/show/40874032", "Victor and Eli started out as college roommates—brilliant, arrogant, lonely boys who recognized the same sharpness and ambition in each other. In their senior year, a shared research interest in adrenaline, near-death experiences, and seemingly supernatural events reveals an intriguing possibility: that under the right conditions, someone could develop extraordinary abilities. But when their thesis moves from the academic to the experimental, things go horribly wrong. \n

Ten years later, Victor breaks out of prison, determined to catch up to his old friend (now foe), aided by a young girl whose reserved nature obscures a stunning ability. Meanwhile, Eli is on a mission to eradicate every other super-powered person that he can find—aside from his sidekick, an enigmatic woman with an unbreakable will. Armed with terrible power on both sides, driven by the memory of betrayal and loss, the archnemeses have set a course for revenge—but who will be left alive at the end? \n

In Vicious, V. E. Schwab brings to life a gritty comic-book-style world in vivid prose: a world where gaining superpowers doesn't automatically lead to heroism, and a time when allegiances are called into question. (Source: Goodreads)", 6);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "We Sold Our Souls", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1527975643l/37715859._SY475_.jpg", "https://www.goodreads.com/book/show/37715859", "In the 1990s, heavy metal band Dürt Würk was poised for breakout success -- but then lead singer Terry Hunt embarked on a solo career and rocketed to stardom as Koffin, leaving his fellow bandmates to rot in rural Pennsylvania.

Two decades later, former guitarist Kris Pulaski works as the night manager of a Best Western - she's tired, broke, and unhappy. Everything changes when she discovers a shocking secret from her heavy metal past: Turns out that Terry's meteoric rise to success may have come at the price of Kris's very soul.

This revelation prompts Kris to hit the road, reunite with the rest of her bandmates, and confront the man who ruined her life. It's a journey that will take her from the Pennsylvania rust belt to a Satanic rehab center and finally to a Las Vegas music festival that's darker than any Mordor Tolkien could imagine. A furious power ballad about never giving up, even in the face of overwhelming odds, We Sold Our Souls is an epic journey into the heart of a conspiracy-crazed, paranoid country that seems to have lost its very soul...where only a girl with a guitar can save us all. (Source: Goodreads)", 7);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "The Library at Mount Char", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1453225113l/26892110.jpg", "https://www.goodreads.com/book/show/26892110", "A missing God.
A library with the secrets to the universe.
A woman too busy to notice her heart slipping away.

Carolyn's not so different from the other people around her. She likes guacamole and cigarettes and steak. She knows how to use a phone. Clothes are a bit tricky, but everyone says nice things about her outfit with the Christmas sweater over the gold bicycle shorts. After all, she was a normal American herself once.

That was a long time ago, of course. Before her parents died. Before she and the others were taken in by the man they called Father. In the years since then, Carolyn hasn't had a chance to get out much. Instead, she and her adopted siblings have been raised according to Father's ancient customs. They've studied the books in his Library and learned some of the secrets of his power. And sometimes, they've wondered if their cruel tutor might secretly be God.  Now, Father is missing—perhaps even dead—and the Library that holds his secrets stands unguarded. And with it, control over all of creation.

As Carolyn gathers the tools she needs for the battle to come, fierce competitors for this prize align against her, all of them with powers that far exceed her own. But Carolyn has accounted for this. And Carolyn has a plan. The only trouble is that in the war to make a new God, she's forgotten to protect the things that make her human.

Populated by an unforgettable cast of characters and propelled by a plot that will shock you again and again, The Library at Mount Char is at once horrifying and hilarious, mind-blowingly alien and heartbreakingly human, sweepingly visionary and nail-bitingly thrilling—and signals the arrival of a major new voice in fantasy. (Source: Goodreads)", 10);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "Space Opera", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1518017807l/24100285.jpg", "https://www.goodreads.com/book/show/24100285", "IN SPACE EVERYONE CAN HEAR YOU SING

A century ago, the Sentience Wars tore the galaxy apart and nearly ended the entire concept of intelligent space-faring life. In the aftermath, a curious tradition was invented-something to cheer up everyone who was left and bring the shattered worlds together in the spirit of peace, unity, and understanding.

Once every cycle, the civilizations gather for the Metagalactic Grand Prix - part gladiatorial contest, part beauty pageant, part concert extravaganza, and part continuation of the wars of the past. Instead of competing in orbital combat, the powerful species that survived face off in a competition of song, dance, or whatever can be physically performed in an intergalactic talent show. The stakes are high for this new game, and everyone is forced to compete.

This year, though, humankind has discovered the enormous universe. And while they expected to discover a grand drama of diplomacy, gunships, wormholes, and stoic councils of aliens, they have instead found glitter, lipstick and electric guitars. Mankind will not get to fight for its destiny - they must sing.

A one-hit-wonder band of human musicians, dancers and roadies from London - Decibel Jones and the Absolute Zeroes - have been chosen to represent Earth on the greatest stage in the galaxy. And the fate of their species lies in their ability to rock. (Source: Goodreads)", 9);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "The 7½ Deaths of Evelyn Hardcastle", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1506896221l/36337550.jpg", "https://www.goodreads.com/book/show/36337550", "Aiden Bishop knows the rules. Evelyn Hardcastle will die every day until he can identify her killer and break the cycle. But every time the day begins again, Aiden wakes up in the body of a different guest at Blackheath Manor. And some of his hosts are more helpful than others. With a locked room mystery that Agatha Christie would envy, Stuart Turton unfurls a breakneck novel of intrigue and suspense.

For fans of Claire North, and Kate Atkinson, The 7½ Deaths of Evelyn Hardcastle is a breathlessly addictive mystery that follows one man's race against time to find a killer, with an astonishing time-turning twist that means nothing and no one are quite what they seem. (Source: Goodreads)", 10);

INSERT INTO books (id, title, field, pic_source, summary_source, summary, author_id) VALUES (NULL, "Soon I Will Be Invincible", "jpg", "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1320554514l/645180.jpg", "https://www.goodreads.com/book/show/645180", "Doctor Impossible—evil genius, diabolical scientist, wannabe world dominator—languishes in a federal detention facility. He's lost his freedom, his girlfriend, and his hidden island fortress.

Over the years he's tried to take over the world in every way imaginable: doomsday devices of all varieties (nuclear, thermonuclear, nanotechnological) and mass mind control. He's traveled backwards in time to change history, forward in time to escape it. He's commanded robot armies, insect armies, and dinosaur armies. Fungus army. Army of fish. Of rodents. Alien invasions. All failures. But not this time. This time it's going to be different...

Fatale is a rookie superhero on her first day with the Champions, the world's most famous superteam. She's a patchwork woman of skin and chrome, a gleaming technological marvel built to be the next generation of warfare. Filling the void left by a slain former member, Fatale joins a team struggling with a damaged past, trying to come together in the face of unthinkable evil.

Soon I Will Be Invincible is a thrilling first novel; a fantastical adventure that gives new meaning to the notions of power, glory, responsibility, and (of course) good and evil. (Source: Goodreads)", 11);


--books that the author likes/views as inpirations
CREATE TABLE author_book_likes(
    id          Integer NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    author_id   INTEGER NOT NULL,
    book_id     INTEGER NOT NULL,

    FOREIGN KEY(author_id) REFERENCES authors(id),
    FOREIGN KEY(book_id) REFERENCES books(id)
);
INSERT INTO author_book_likes (author_id, book_id) VALUES (1,3);
INSERT INTO author_book_likes (author_id, book_id) VALUES (2,4);
INSERT INTO author_book_likes (author_id, book_id) VALUES (3,5);
INSERT INTO author_book_likes (author_id, book_id) VALUES (4,6);
INSERT INTO author_book_likes (author_id, book_id) VALUES (5,7);
INSERT INTO author_book_likes (author_id, book_id) VALUES (6,8);
INSERT INTO author_book_likes (author_id, book_id) VALUES (7,9);
INSERT INTO author_book_likes (author_id, book_id) VALUES (8,10);
INSERT INTO author_book_likes (author_id, book_id) VALUES (9,11);
INSERT INTO author_book_likes (author_id, book_id) VALUES (3,4);
INSERT INTO author_book_likes (author_id, book_id) VALUES (8,4);
INSERT INTO author_book_likes (author_id, book_id) VALUES (11,5);
INSERT INTO author_book_likes (author_id, book_id) VALUES (10,3);
INSERT INTO author_book_likes (author_id, book_id) VALUES (6,9);

--authors that list themselves as similar to each other
CREATE TABLE author_author(
    id          INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    first_author_id     INTEGER NOT NULL,
    second_author_id    INTEGER NOT NULL,

    FOREIGN KEY(first_author_id) REFERENCES authors(id),
    FOREIGN KEY(second_author_id) REFERENCES authors(id)
);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (1,3);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (1,2);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (3,7);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (2, 4);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (3, 2);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (5, 9);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (5,2);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (5,8);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (5, 1);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (1,7);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (6,7);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (4,5);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (10,11);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (8,2);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (6,3);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (2,8);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (9,3);
INSERT INTO author_author (first_author_id,second_author_id) VALUES (7,8);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (3, 4);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (4, 3);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (4,8);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (7,1);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (7,9);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (7,3);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (10,2);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (10, 4);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (10, 5);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (11,7);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (11,6);
INSERT INTO author_author (first_author_id, second_author_id) VALUES (11,10);

--tags for books and authors

CREATE TABLE tags(
    id          INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    tag         TEXT NOT NULL
);

INSERT INTO tags (tag) VALUES ("Fantasy");
INSERT INTO tags (tag) VALUES ("Science-Fiction");
INSERT INTO tags (tag) VALUES ("Thriller");
INSERT INTO tags (tag) VALUES ("Horror");
INSERT INTO tags (tag) VALUES ("Mystery");
INSERT INTO tags (tag) VALUES ("Romance");
INSERT INTO tags (tag) VALUES ("Non-Fiction");
INSERT INTO tags (tag) VALUES ("Other");


CREATE TABLE tag_author (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    tag_id INTEGER NOT NULL,
    author_id INTEGER NOT NULL,

    FOREIGN KEY(author_id) REFERENCES authors(id),
    FOREIGN KEY(tag_id) REFERENCES tags(id)
);

INSERT INTO tag_author (tag_id, author_id) VALUES (1, 1);
INSERT INTO tag_author (tag_id, author_id) VALUES (2, 2);
INSERT INTO tag_author (tag_id, author_id) VALUES (3, 3);
INSERT INTO tag_author (tag_id, author_id) VALUES (4, 4);
INSERT INTO tag_author (tag_id, author_id) VALUES (4, 5);
INSERT INTO tag_author (tag_id, author_id) VALUES (1, 6);
INSERT INTO tag_author (tag_id, author_id) VALUES (4, 7);
INSERT INTO tag_author (tag_id, author_id) VALUES (3, 8);
INSERT INTO tag_author (tag_id, author_id) VALUES (2, 9);
INSERT INTO tag_author (tag_id, author_id) VALUES (5, 10);
INSERT INTO tag_author (tag_id, author_id) VALUES (2, 11);
INSERT INTO tag_author (tag_id, author_id) VALUES (4,1);

CREATE TABLE tag_book(
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    tag_id INTEGER NOT NULL,
    book_id INTEGER NOT NULL,

    FOREIGN KEY(book_id) REFERENCES books(id),
    FOREIGN KEY(tag_id) REFERENCES tag(id)
);

INSERT INTO tag_book (tag_id, book_id) VALUES (1, 1);
INSERT INTO tag_book (tag_id, book_id) VALUES (2, 2);
INSERT INTO tag_book (tag_id, book_id) VALUES (5, 3);
INSERT INTO tag_book (tag_id, book_id) VALUES (4, 4);
INSERT INTO tag_book (tag_id, book_id) VALUES (4, 5);
INSERT INTO tag_book (tag_id, book_id) VALUES (2, 6);
INSERT INTO tag_book (tag_id, book_id) VALUES (4, 7);
INSERT INTO tag_book (tag_id, book_id) VALUES (1, 8);
INSERT INTO tag_book (tag_id, book_id) VALUES (2, 9);
INSERT INTO tag_book (tag_id, book_id) VALUES (5, 10);
INSERT INTO tag_book (tag_id, book_id) VALUES (2, 11);
INSERT INTO tag_book (tag_id, book_id) VALUES (3, 3);
INSERT INTO tag_book (tag_id, book_id) VALUES (4, 1);

CREATE TABLE sessions (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	user_id INTEGER NOT NULL,
	session TEXT NOT NULL UNIQUE,
    last_login   TEXT NOT NULL,

  FOREIGN KEY(user_id) REFERENCES authors(id)
);
