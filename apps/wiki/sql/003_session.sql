begin;

CREATE TABLE session_base
(
  session_id text NOT NULL,
  last_active timestamp with time zone NOT NULL,
  CONSTRAINT session_base_pkey PRIMARY KEY (session_id)
);

CREATE TABLE session_data
(
  session_id text NOT NULL references session_base,
  "key" text NOT NULL,
  "value" text,
  CONSTRAINT session_data_pkey PRIMARY KEY (session_id, key)
);

commit;