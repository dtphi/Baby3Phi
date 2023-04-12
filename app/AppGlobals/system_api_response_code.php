<?php
// Success
const RESPONSE_OK = 2000;

const RESPONSE_CREATED = 2001;

const RESPONSE_UPDATED = 2002;

const RESPONSE_DELETED = 2003;

const RESPONSE_IN_PROGRESS = 2004;

// Unexpected error (bug)

// eg: database connection error
const RESPONSE_SERVER_ERROR = 5000;

// eg: JSON request body couldn't be parsed
const RESPONSE_BAD_REQUEST = 5001;

// User is not authorised to perform the requested action
const RESPONSE_AUTHORISATION_FAILED = 5002;

// eg: no route matches the URL; no entity exists with the specified ID
const RESPONSE_NOT_FOUND = 5003;

// Invalid/missing HMAC signature
const RESPONSE_INVALID_SIGNATURE = 5004;

// Child entity doesn't belong to parent entity
const RESPONSE_INVALID_RELATIONSHIP = 5005;

// API version was not specified, or is invalid
const RESPONSE_INVALID_API_VERSION = 5006;

// Client is using an HTTP connection instead of HTTPS
const RESPONSE_INSECURE_CONNECTION = 5007;

// conflict || duplicate data
const RESPONSE_CONFLICT = 5008;

// Any other error
const RESPONSE_UNKNOWN_ERROR = 5999;
