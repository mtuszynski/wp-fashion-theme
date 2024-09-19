export const numberToPercent = (value: number): number => {
  if (value > 100) {
    return 100;
  }

  if (value < 0) {
    return 0;
  }

  return parseFloat(value.toFixed(2));
}