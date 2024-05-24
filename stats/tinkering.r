library("pacman")

p_load(
    "tidyverse",
    "readxl"
)

# Load the data
df_supporters <- read.csv("stats/data/supporters-2024-05-24-19-46-51.csv")
view(df_supporters)

## Filter df_supporters where stage=pledge
df_supporters_pledge <- df_supporters %>%
    filter(stage == "pledge")

## Add datetime column converting created_at to date
df_supporters_pledge <- df_supporters_pledge %>%
    mutate(datetime = as.POSIXct(created_at, format = "%Y-%m-%dT%H:%M:%S.000000Z"))
view(df_supporters_pledge)

## Calculate the number of hours since the first pledge
hours_since_first_pledge <- df_supporters_pledge %>%
    summarize(
        hours_since_first_pledge = round(as.numeric(difftime(max(datetime), min(datetime), units = "hours")))
    )

## Loop through the number of hours since the first pledge and calculate the number of rows for each hour, adding to a dataframe
df_hours_since_first_pledge <- data.frame()
for (i in 0:hours_since_first_pledge$hours_since_first_pledge) {
    time_cutoff <- min(df_supporters_pledge$datetime) + hours(i)
    df_hours_since_first_pledge <- df_hours_since_first_pledge %>%
        bind_rows(
            df_supporters_pledge %>%
                filter(
                    datetime <= time_cutoff,
                    datetime > time_cutoff - hours(1)
                ) %>%
                summarize(
                    time = time_cutoff,
                    num_supporters = n(),
                    num_signatures = sum(as.numeric(signatureCount))
                )
        )
}

sum(df_supporters_pledge$signatureCount)

view(df_hours_since_first_pledge)
